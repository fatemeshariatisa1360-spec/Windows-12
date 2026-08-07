<?php
// تنظیمات اعتبار سنجی Cloudflare Turnstile
$turnstile_secret_key = "0x4AAAAAAEJZ2f5akLI-Nb6Q2B6WBXnyB2M";
$verification_message = "";

// بررسی اینکه آیا کاربر از سمت ویجت تایید را فرستاده است یا خیر
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['cf-turnstile-response'] ?? '';
    
    if (!empty($token)) {
        $verify_url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
        $data = [
            'secret' => $turnstile_secret_key,
            'response' => $token,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        
        $context = stream_context_create($options);
        $result = @file_get_contents($verify_url, false, $context);
        $result_json = json_decode($result);

        if ($result_json && $result_json->success) {
            // تایید موفقیت‌آمیز: تنظیم یک کوکی موقت Session که با بستن مرورگر منقضی می‌شود
            setcookie("turnstile_verified", "true", 0, "/");
            // رفرش کردن صفحه برای ورود به بخش اصلی سایت
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $verification_message = "تایید امنیتی ناموفق بود. لطفاً دوباره تلاش کنید.";
        }
    } else {
        $verification_message = "لطفاً تایید کنید که ربات نیستید.";
    }
}

// بررسی اینکه آیا کاربر قبلاً در این نشست (Session) تایید کرده است یا خیر
$is_verified = isset($_COOKIE['turnstile_verified']) && $_COOKIE['turnstile_verified'] === "true";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="google-site-verification" content="JbcfgMjgGYaYToXGUplllcEw7HxHVW9QY9oHnlItAcU" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Windows 12 - HP Portal</title>
    <!-- اسکریپت رسمی کلادفلر Turnstile -->
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <style>
        body {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            line-height: 1.6;
            text-align: center;
            background-color: #e0f2f1;
            margin: 0;
            padding: 0;
            color: #2b2b2b;
        }
        /* استایل صفحه اختصاصی تایید ربات (در صورتی که تایید نشده باشد) */
        .turnstile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #e0f2f1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .turnstile-box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            max-width: 400px;
            width: 90%;
        }
        .HP-title {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            width: fit-content;
            margin: 30px auto;
            padding: 8px 20px;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            background-color: rgba(255, 255, 255, 0.85);
        }
        .highlight-text {
            background-color: rgba(255, 255, 255, 0.85);
            padding: 10px;
            width: fit-content;
            margin: 20px auto;
            border-radius: 5px;
        }
        mark {
            background-color: transparent !important;
            font-weight: bold;
        }
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            background-color: rgba(255, 255, 255, 0.85);
        }
        td, th {
            border: 1px solid rgba(0,0,0,0.2);
            text-align: left;
            padding: 12px;
        }
        .city {
            border: 2px solid rgba(0,0,0,0.3);
            margin: 20px auto;
            max-width: 800px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            background-color: rgba(255, 255, 255, 0.85);
        }
        * {
            box-sizing: border-box;
        }
        header {
            padding: 30px;
            text-align: center;
            font-size: 35px;
            background-color: rgba(255, 255, 255, 0.85);
            margin: 20px auto;
            max-width: 800px;
            border-radius: 8px;
        }
        nav {
            float: left;
            width: 30%;
            min-height: 300px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.85);
        }
        nav ul {
            list-style-type: none;
            padding: 0;
        }
        article {
            float: left;
            padding: 20px;
            width: 70%;
            min-height: 300px;
            text-align: left;
            background-color: rgba(255, 255, 255, 0.85);
        }
        section {
            max-width: 1000px;
            margin: 20px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        section::after {
            content: "";
            display: table;
            clear: both;
        }
        footer {
            padding: 15px;
            text-align: center;
            clear: both;
            background-color: rgba(255, 255, 255, 0.85);
            max-width: 1000px;
            margin: 20px auto;
            border-radius: 8px;
        }
        .animated-box {
            border: 2px solid rgba(0,0,0,0.3);
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            margin: 20px auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            background-color: rgba(255, 255, 255, 0.85);
        }
        @media (max-width: 600px) {
            nav, article {
                width: 100%;
                height: auto;
            }
            table {
                width: 100%;
            }
        }
        iframe {
            max-width: 100%;
            border: 2px solid rgba(0,0,0,0.2);
            border-radius: 6px;
            margin: 15px 0;
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: rgba(255, 255, 255, 0.85);
        }
        a {
            text-decoration: none;
            color: #0d47a1;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
    <link rel="icon" type="image/x-icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/HP_logo_2025.svg/960px-HP_logo_2025.svg.png">
</head>
<body>

<?php if (!$is_verified): ?>
    <!-- صفحه تایید ربات که قبل از ورود به سایت نمایش داده می‌شود -->
    <div class="turnstile-overlay">
        <div class="turnstile-box">
            <h2>تایید امنیتی</h2>
            <p>لطفاً برای ورود به سایت تایید کنید که ربات نیستید.</p>
            <form action="" method="POST">
                <!-- استفاده از Site Key جدید شما -->
                <div class="cf-turnstile" data-sitekey="0x4AAAAAAAEJZ2h-ZeJX6WRL" data-theme="light"></div>
                <br>
                <button type="submit" style="padding: 10px 20px; background-color: #0d47a1; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">تایید و ورود</button>
            </form>
            <?php if (!empty($verification_message)): ?>
                <p style="color: red; margin-top: 15px;"><?php echo $verification_message; ?></p>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>

    <!-- محتوای اصلی سایت شما (بعد از تایید نمایش داده می‌شود) -->
    <h4 class="HP-title">
        <i><b><u>HP</u></b></i>
    </h4>

    <p class="highlight-text">
        <mark>The Windows 12 well Finish Made on 1 Year Later.</mark>
    </p>

    <h2>To Download Windows Versions, Visit Microsoft and Download For Free!</h2>

    <img src="https://w3schools.com/html/Workplace.jpg" width="394" height="379" alt="Windows 12" usemap="#WindowsMap">

    <map name="WindowsMap">
        <area shape="rect" coords="290,172,333,250" alt="Phone" href="https://w3schools.com/html/Computer.htm" target="_blank">
        <area shape="rect" coords="34,44,270,350" alt="Computer" href="https://w3schools.com/html/Phone.htm" target="_blank">
        <area shape="circle" coords="337,300,44" alt="Coffee" href="https://w3schools.com/html/coffee.htm" target="_blank">
    </map>

    <br><br>
    <h5>You Need VPN To Download The Icon Of This Site. If You Don't Have VPN, Visit To Google Chrome Web Store And Search For VeePN And Download It.</h5>
    <a href="https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/HP_logo_2025.svg/960px-HP_logo_2025.svg.png?utm_source=en.wikipedia.org&utm_campaign=imageinfo&utm_content=thumbnail" target="_blank">Download The Icon Of The Site</a>
    <br><br><br>

    <h2>Company's Are Ready To Made Windows 12</h2>
    <table>
        <tr>
            <th>Company</th>
            <th>Contact</th>
            <th>Country</th>
        </tr>
        <tr>
            <td>HP</td>
            <td>Unknown</td>
            <td>USA</td>
        </tr>
    </table>

    <div class="city">
        <h2>Windows 12 Have Thoose</h2>
        <p style="font-size: xx-large;">Microsoft AI</p>
    </div> 

    <div class="city">
        <h2></h2>
        <p style="font-size: xx-large;">More Dynamic User interface</p>
    </div>

    <div class="city">
        <h2></h2>
        <p style="font-size: xx-large;">Scalability</p>
    </div>

    <div class="city">
        <h2></h2>
        <p style="font-size: xx-large;">Quick Update</p>
    </div>

    <header>
        <h2>About HP</h2>
    </header>

    <section>
        <nav>
            <ul>
                <br><br>
                <h1 style="font-size: 24px;">About HP</h1>
            </ul>
        </nav>
        
        <article>
            <h1 style="font-size: 18px; font-weight: normal;">HP is an American multinational electronics conglomerate headquartered in California, USA. The company focuses primarily on the production of laptops and electronic devices, and some users are satisfied with its laptop manufacturing.</h1>
            <p></p>
            <p></p>
        </article>
    </section>

    <footer>
        <p style="font-size: x-large;">About HP</p>
    </footer>

    <h2>login Page Iframe</h2>

    <iframe src="https://login-hp.onrender.com" height="600" width="100%" style="max-width: 1300px;" title="Iframe"></iframe>

    <div class="animated-box">
        <h2>If You Log in But You Cannot Go To You DashBoard With Iframe</h2>
        <a href="https://login-hp.onrender.com/index.php?page=dashboard" target="_blank">Direct access to the dashboard</a>
        <br><br>
        <h2>If You Don't Log in , Use The Login Page Iframe Or</h2>
        <a href="https://login-hp.onrender.com" target="_blank">Direct access to the Login Page</a>
    </div>

    <div class="animated-box">
        <h2>TelePhone Number : +989395391900</h2>
        <br>
        <h2>This Site is Maded By</h2>
        <a href="https://hp.com" target="_blank">HP</a>
        <br><br>
        <p style="font-size: 12px; color: #555;">This site is protected by Cloudflare Turnstile and the <a href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a> and <a href="https://policies.google.com/terms" target="_blank">Terms of Service</a> apply.</p>
    </div>

<?php endif; ?>

</body>
</html>
