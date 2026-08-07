<?php
// Handle Google reCAPTCHA v3 configuration implementation
$rec_site_key = "6LeotnktAAAAAD9smf4dVq9erT6ojRBAldOImGHV";
$rec_secret_key = "6LeotnktAAAAAPYJvoOr4S_RjNXniOKEebuz4OF9";
$recaptcha_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';
    
    if (!empty($recaptcha_response)) {
        $verify_url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $rec_secret_key,
            'response' => $recaptcha_response,
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
            $recaptcha_message = "reCAPTCHA verification successful.";
        } else {
            $recaptcha_message = "reCAPTCHA verification failed. Please try again.";
        }
    } else {
        $recaptcha_message = "Please complete the reCAPTCHA.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="google-site-verification" content="JbcfgMjgGYaYToXGUplllcEw7HxHVW9QY9oHnlItAcU" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Windows 12 - HP Portal</title>
    <!-- Include Google reCAPTCHA API script with site key -->
    <script src="https://www.google.com/recaptcha/api.js?render=6LeotnktAAAAAD9smf4dVq9erT6ojRBAldOImGHV" async defer></script>
    <style>
        @keyframes fadeInSlide {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes rainbowBg {
            0% { background-color: #ff9a9e; }
            10% { background-color: #fad0c4; }
            20% { background-color: #ffd1ff; }
            30% { background-color: #a1c4fd; }
            40% { background-color: #c2e9fb; }
            50% { background-color: #d4fc79; }
            60% { background-color: #96e6a1; }
            70% { background-color: #fccb90; }
            80% { background-color: #e2b0ff; }
            90% { background-color: #ffecd2; }
            100% { background-color: #ff9a9e; }
        }

        @keyframes rainbowText {
            0% { color: #2b2b2b; }
            15% { color: #880e4f; }
            30% { color: #0d47a1; }
            45% { color: #1b5e20; }
            60% { color: #e65100; }
            75% { color: #4a148c; }
            90% { color: #006064; }
            100% { color: #2b2b2b; }
        }

        @keyframes rainbowContainerBg {
            0% { background-color: rgba(255, 255, 255, 0.85); }
            20% { background-color: rgba(220, 237, 200, 0.85); }
            40% { background-color: rgba(187, 222, 251, 0.85); }
            60% { background-color: rgba(255, 224, 178, 0.85); }
            80% { background-color: rgba(225, 190, 231, 0.85); }
            100% { background-color: rgba(255, 255, 255, 0.85); }
        }

        body {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            line-height: 1.6;
            text-align: center;
            animation: rainbowBg 4s ease infinite, fadeInSlide 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            margin: 0;
            padding: 0;
        }

        /* Safe dedicated class for text animation, avoiding third-party widgets like reCAPTCHA */
        .rainbow-text {
            animation: rainbowText 4s ease infinite;
        }

        .HP-title, .highlight-text, table, .city, header, nav, article, footer, .animated-box, img {
            animation: rainbowContainerBg 4s ease infinite, fadeInSlide 1s cubic-bezier(0.16, 1, 0.3, 1) forwards !important;
        }

        .HP-title {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            width: fit-content;
            margin: 30px auto;
            padding: 8px 20px;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
            transition: transform 0.3s ease;
        }

        .city:hover {
            transform: translateY(-3px);
        }

        * {
            box-sizing: border-box;
        }

        header {
            padding: 30px;
            text-align: center;
            font-size: 35px;
        }

        nav {
            float: left;
            width: 30%;
            min-height: 300px;
            padding: 20px;
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
        }

        .animated-box {
            border: 2px solid rgba(0,0,0,0.3);
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            margin: 20px auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
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
        }

        a {
            text-decoration: none;
            transition: color 0.2s ease;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
    <link rel="icon" type="image/x-icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/HP_logo_2025.svg/960px-HP_logo_2025.svg.png">
</head>
<body>

    <!-- Section Title -->
    <h4 class="HP-title rainbow-text">
        <i><b><u>HP</u></b></i>
    </h4>

    <p class="highlight-text rainbow-text">
        <mark>The Windows 12 well Finish Made on 1 Year Later.</mark>
    </p>

    <h2 class="rainbow-text">To Download Windows Versions, Visit Microsoft and Download For Free!</h2>

    <img src="https://w3schools.com/html/Workplace.jpg" width="394" height="379" alt="Windows 12" usemap="#WindowsMap">

    <map name="WindowsMap">
        <area shape="rect" coords="290,172,333,250" alt="Phone" href="https://w3schools.com/html/Computer.htm" target="_blank">
        <area shape="rect" coords="34,44,270,350" alt="Computer" href="https://w3schools.com/html/Phone.htm" target="_blank">
        <area shape="circle" coords="337,300,44" alt="Coffee" href="https://w3schools.com/html/coffee.htm" target="_blank">
    </map>

    <br><br>
    <h5 class="rainbow-text">You Need VPN To Download The Icon Of This Site. If You Don't Have VPN, Visit To Google Chrome Web Store And Search For VeePN And Download It.</h5>
    <a href="https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/HP_logo_2025.svg/960px-HP_logo_2025.svg.png?utm_source=en.wikipedia.org&utm_campaign=imageinfo&utm_content=thumbnail" target="_blank" class="rainbow-text">Download The Icon Of The Site</a>
    <br><br><br>

    <h2 class="rainbow-text">Company's Are Ready To Made Windows 12</h2>

    <table>
        <tr>
            <th class="rainbow-text">Company</th>
            <th class="rainbow-text">Contact</th>
            <th class="rainbow-text">Country</th>
        </tr>
        <tr>
            <td class="rainbow-text">HP</td>
            <td class="rainbow-text">Unknown</td>
            <td class="rainbow-text">USA</td>
        </tr>
    </table>

    <div class="city">
        <h2 class="rainbow-text">Windows 12 Have Thoose</h2>
        <p style="font-size: xx-large;" class="rainbow-text">Microsoft AI</p>
    </div> 

    <div class="city">
        <h2 class="rainbow-text"></h2>
        <p style="font-size: xx-large;" class="rainbow-text">More Dynamic User interface</p>
    </div>

    <div class="city">
        <h2 class="rainbow-text"></h2>
        <p style="font-size: xx-large;" class="rainbow-text">Scalability</p>
    </div>

    <div class="city">
        <h2 class="rainbow-text"></h2>
        <p style="font-size: xx-large;" class="rainbow-text">Quick Update</p>
    </div>

    <?php if (!empty($recaptcha_message)): ?>
        <p style="font-weight: bold; color: #fff; background: rgba(0,0,0,0.5); padding: 10px; width: fit-content; margin: 20px auto; border-radius: 5px;" class="rainbow-text"><?php echo $recaptcha_message; ?></p>
    <?php endif; ?>

    <h2 class="rainbow-text">Iframe</h2>
    <p class="rainbow-text">You Can Use The Site Iframe</p>

    <iframe src="http://localhost/auth/Windows 12.php" height="600" width="100%" style="max-width: 1300px;" title="Iframe"></iframe>

    <header>
        <h2 class="rainbow-text">About HP</h2>
    </header>

    <section>
        <nav>
            <ul>
                <br><br>
                <h1 style="font-size: 24px;" class="rainbow-text">About HP</h1>
            </ul>
        </nav>
        
        <article>
            <h1 style="font-size: 18px; font-weight: normal;" class="rainbow-text">HP is an American multinational electronics conglomerate headquartered in California, USA. The company focuses primarily on the production of laptops and electronic devices, and some users are satisfied with its laptop manufacturing.</h1>
            <p class="rainbow-text"></p>
            <p class="rainbow-text"></p>
        </article>
    </section>

    <footer>
        <p style="font-size: x-large;" class="rainbow-text">About HP</p>
    </footer>

    <h2 class="rainbow-text">login Page Iframe</h2>

    <iframe src="http://localhost/auth/login.php" height="600" width="100%" style="max-width: 1300px;" title="Iframe"></iframe>

    <div class="animated-box">
        <h2 class="rainbow-text">If You Log in But You Cannot Go To You DashBoard With Iframe</h2>
        <a href="http://localhost/auth/login.php?page=dashboard" target="_blank" class="rainbow-text">Direct access to the dashboard</a>
        <br><br>
        <h2 class="rainbow-text">If You Don't Log in , Use The Login Page Iframe Or</h2>
        <a href="http://localhost/auth/login.php" target="_blank" class="rainbow-text">Direct access to the Login Page</a>
    </div>

    <div class="animated-box">
        <h2 class="rainbow-text">TelePhone Number : +989395391900</h2>
        <br>
        <h2 class="rainbow-text">This Site is Maded By</h2>
        <a href="https://hp.com" target="_blank" class="rainbow-text">HP</a>
    </div>

</body>
</html>
