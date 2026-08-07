<?php
// ۱. تنظیمات اتصال به پایگاه داده
define('USER', 'root');
define('PASSWORD', '');
define('HOST', 'localhost');
define('DATABASE', 'test');

// کلیدهای جدید ریکپچا
define('RECAPTCHA_SITE_KEY', '6LcjEnUtAAAAACiUr6AaOzC3Mx9o9NZSvhU1-cLu'); 
define('RECAPTCHA_SECRET_KEY', '6LcjEnUtAAAAABbE5wohloOHPQ007Suyri8Kbr_F');

try {
    $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // اطمینان از وجود جدول کاربران
    $connection->exec("CREATE TABLE IF NOT EXISTS users (
        ID INT AUTO_INCREMENT PRIMARY KEY,
        USERNAME VARCHAR(50) NOT NULL UNIQUE,
        PASSWORD VARCHAR(255) NOT NULL,
        EMAIL VARCHAR(100) NOT NULL
    )");
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}

// شروع سشن
session_start();

$message = '';
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

// تابع اعتبارسنجی سرور گوگل
function validateGoogleCaptcha($response_token) {
    if (empty($response_token)) return false;
    
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret'   => RECAPTCHA_SECRET_KEY,
        'response' => $response_token,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];
    
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    if ($result === FALSE) return false;
    
    $responseKeys = json_decode($result, true);
    return !empty($responseKeys["success"]);
}

$self = basename(__FILE__);

// عملیات خروج از حساب
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    echo "<script>
        localStorage.removeItem('saved_username');
        localStorage.removeItem('saved_password');
        window.location.href = '{$self}?page=login';
    </script>";
    exit;
}

// ۲. پردازش فرم ثبت‌نام
if (isset($_POST['register'])) {
    $recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
    
    if (!validateGoogleCaptcha($recaptcha_response)) {
        $message = 'Please complete the Google reCAPTCHA verification!';
    } else {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $query = $connection->prepare("SELECT * FROM users WHERE EMAIL=:email OR USERNAME=:username");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();

        if ($query->rowCount() > 0) {
            $message = 'This email or username is already registered!';
        } else {
            $query = $connection->prepare("INSERT INTO users(USERNAME,PASSWORD,EMAIL) VALUES (:username,:password_hash,:email)");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $result = $query->execute();

            if ($result) {
                $_SESSION['temp_username'] = $username;
                $_SESSION['temp_password'] = $password;
                
                // نمایش صفحه سفید شامل نام کاربری و رمز عبور و ذخیره در LocalStorage
                echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>Registration Success</title>
                    <style>
                        body { background: #ffffff; color: #000; font-family: Arial, sans-serif; text-align: center; padding-top: 100px; }
                        .box { border: 2px solid #9acd32; display: inline-block; padding: 30px; border-radius: 10px; background: #f9f9f9; }
                        h2 { color: #9acd32; }
                        a { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #9acd32; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
                    </style>
                </head>
                <body>
                    <div class="box">
                        <h2>Registration Successful!</h2>
                        <p><strong>Username:</strong> <span id="reg_user">' . htmlspecialchars($username) . '</span></p>
                        <p><strong>Password:</strong> <span id="reg_pass">' . htmlspecialchars($password) . '</span></p>
                        <br>
                        <a href="' . $self . '?page=login">Go to Login</a>
                    </div>
                    <script>
                        localStorage.setItem("saved_username", "' . $username . '");
                        localStorage.setItem("saved_password", "' . $password . '");
                    </script>
                </body>
                </html>';
                exit;
            } else {
                $message = 'Database error occurred!';
            }
        }
    }
}

// ۳. پردازش فرم ورود
if (isset($_POST['login'])) {
    $recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
    
    if (!validateGoogleCaptcha($recaptcha_response)) {
        $message = 'Please complete the Google reCAPTCHA verification!';
    } else {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        $query = $connection->prepare("SELECT * FROM users WHERE USERNAME=:username");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (!$result || !password_verify($password, $result['PASSWORD'])) {
            // رفرش صفحه همراه با خطا در صورت اشتباه بودن مشخصات
            echo "<script>
                alert('Invalid username or password!');
                window.location.href = '{$self}?page=login';
            </script>";
            exit;
        } else {
            $_SESSION['user_id'] = $result['ID'];
            $_SESSION['username'] = $result['USERNAME'];
            
            // نمایش صفحه سفید مجزا پس از ورود موفق به همراه نام کاربری و رمز عبور
            echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Login Success</title>
                <style>
                    body { background: #ffffff; color: #000; font-family: Arial, sans-serif; text-align: center; padding-top: 100px; }
                    .box { border: 2px solid #9acd32; display: inline-block; padding: 30px; border-radius: 10px; background: #f9f9f9; }
                    h2 { color: #9acd32; }
                    a { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #9acd32; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
                </style>
            </head>
            <body>
                <div class="box">
                    <h2>Login Successful!</h2>
                    <p><strong>Username:</strong> ' . htmlspecialchars($username) . '</p>
                    <p><strong>Password:</strong> ' . htmlspecialchars($password) . '</p>
                    <br>
                    <a href="' . $self . '?page=dashboard">Go to Dashboard</a>
                </div>
                <script>
                    localStorage.setItem("saved_username", "' . $username . '");
                    localStorage.setItem("saved_password", "' . $password . '");
                </script>
            </body>
            </html>';
            exit;
        }
    }
}

// کنترل دسترسی سشن‌ها
if (isset($_SESSION['user_id']) && ($page == 'login' || $page == 'register')) {
    header("Location: {$self}?page=dashboard");
    exit;
}

if ($page == 'dashboard' && !isset($_SESSION['user_id'])) {
    header("Location: {$self}?page=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Authentication System</title>
    <!-- لود کتابخانه رسمی ریکپچا با زبان انگلیسی -->
    <script src="https://www.google.com/recaptcha/api.js?hl=en" async defer></script>
    
    <style>
        * { padding: 0; margin: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, sans-serif; } 
        body { background-color: #f3f4f6; display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 100vh; padding: 15px; } 
        
        .container { width: 100%; max-width: 420px; background: #ffffff; padding: 30px 25px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        
        h1 { font-size: 1.6rem; margin-bottom: 25px; color: #2d3748; text-align: center; font-weight: 700; } 
        .form-element { margin-bottom: 18px; text-align: left; } 
        label { display: block; font-size: 0.95rem; margin-bottom: 8px; color: #4a5568; font-weight: 600; } 
        
        input { width: 100%; border: 2px solid #cbd5e1; font-size: 1.05rem; padding: 11px 14px; border-radius: 8px; transition: all 0.3s; text-align: left; direction: ltr; } 
        input:focus { border-color: #9acd32; outline: none; box-shadow: 0 0 0 3px rgba(154, 205, 50, 0.15); }
        
        button { width: 100%; padding: 12px; font-size: 1.15rem; font-weight: bold; background: #9acd32; color: white; border: none; border-radius: 8px; cursor: pointer; transition: background 0.2s; margin-top: 15px; } 
        button:hover { background: #86b328; } 
        
        p.error-msg { color: white; background: #ff4500; display: block; padding: 12px; margin-bottom: 20px; border-radius: 8px; font-size: 0.95rem; text-align: center; width: 100%; max-width: 420px; }
        
        .footer-link { margin-top: 25px; text-align: center; font-size: 0.9rem; }
        .footer-link a { color: #86b328; text-decoration: none; font-weight: 700; }
        .footer-link a:hover { text-decoration: underline; }
        
        .captcha-wrapper { width: 100%; display: flex; justify-content: center; margin: 15px 0; overflow: hidden; }
        .captcha-container { width: 304px; height: 78px; }
        
        @media (max-width: 380px) {
            .container { padding: 20px 15px; }
            .captcha-container { transform: scale(0.85); transform-origin: center center; }
        }
    </style>
</head>
<body>

    <?php if(!empty($message)) echo '<p class="error-msg">' . $message . '</p>'; ?>
    
    <div class="container">
        <?php if ($page == 'register'): ?>
            <!-- Registration Form -->
            <h1>Sign Up</h1>
            <form method="post" action="<?php echo $self; ?>?page=register" name="signup-form"> 
                <div class="form-element"> 
                    <label>Username</label> 
                    <input type="text" id="reg_username" name="username" pattern="[a-zA-Z0-9]+" required /> 
                </div> 
                <div class="form-element"> 
                    <label>Email</label> 
                    <input type="email" name="email" required /> 
                </div> 
                <div class="form-element"> 
                    <label>Password</label> 
                    <input type="password" id="reg_password" name="password" required /> 
                </div> 
                
                <div class="captcha-wrapper">
                    <div class="captcha-container">
                        <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>"></div>
                    </div>
                </div>

                <button type="submit" name="register" value="register">Register</button> 
            </form>
            <div class="footer-link"><a href="<?php echo $self; ?>?page=login">Already have an account? Sign In</a></div>

        <?php elseif ($page == 'dashboard'): ?>
            <!-- Dashboard -->
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <div class="form-element" style="margin: 30px 0; text-align:center;">
                <p style="color: #4a5568; font-size: 1.1rem; line-height: 1.6;">Username: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
            </div>
            <div class="footer-link"><a href="<?php echo $self; ?>?action=logout" style="color: #ff4500;">Logout</a></div>

        <?php else: ?>
            <!-- Login Form -->
            <h1>Sign In</h1>
            <form method="post" action="<?php echo $self; ?>?page=login" name="signin-form"> 
                <div class="form-element"> 
                    <label>Username</label> 
                    <input type="text" id="login_username" name="username" pattern="[a-zA-Z0-9]+" required /> 
                </div> 
                <div class="form-element"> 
                    <label>Password</label> 
                    <input type="password" id="login_password" name="password" required /> 
                </div> 
                
                <div class="captcha-wrapper">
                    <div class="captcha-container">
                        <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>"></div>
                    </div>
                </div>

                <button type="submit" name="login" value="login">Login</button> 
            </form>
            <div class="footer-link"><a href="<?php echo $self; ?>?page=register">Don't have an account? Sign Up</a></div>
        <?php endif; ?>
    </div>

    <script>
        // خودکار پر کردن فیلدها از LocalStorage برای جلوگیری از ورود مجدد دستی
        document.addEventListener("DOMContentLoaded", function() {
            let savedUser = localStorage.getItem("saved_username");
            let savedPass = localStorage.getItem("saved_password");
            
            if (savedUser) {
                let uInput = document.getElementById("login_username") || document.getElementById("reg_username");
                if (uInput) uInput.value = savedUser;
            }
            if (savedPass) {
                let pInput = document.getElementById("login_password") || document.getElementById("reg_password");
                if (pInput) pInput.value = savedPass;
            }
        });
    </script>
</body>
</html>