<?php
// تنظیمات اعتبار سنجی Google reCAPTCHA (در صورت نیاز به بررسی در پس‌زمینه)
$recaptcha_secret_key = "6LcOX3otAAAAAADwyFfyJcmG963x7zVnChqr1xzm";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="google-site-verification" content="JbcfgMjgGYaYToXGUplllcEw7HxHVW9QY9oHnlItAcU" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Windows 12 - HP Portal</title>
    <!-- اسکریپت رسمی Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
        /* استایل بنر شناور ریکپچا در سمت راست صفحه */
        .recaptcha-badge-fixed {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 99998;
            background: #ffffff;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            overflow: hidden;
            font-family: Roboto, helvetica, arial, sans-serif;
            border: 1px solid #c1c1c1;
        }
        .recaptcha-badge-fixed .badge-logo {
            padding: 6px 10px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .recaptcha-badge-fixed .badge-logo img {
            width: 32px;
            height: 32px;
            box-shadow: none;
            background: transparent;
        }
        .recaptcha-badge-fixed .badge-text {
            background-color: #1a73e8;
            color: #ffffff;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.3px;
        }
    </style>
    <link rel="icon" type="image/x-icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/HP_logo_2025.svg/960px-HP_logo_2025.svg.png">
</head>
<body>

    <!-- محتوای اصلی سایت -->
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
        <p style="font-size: 12px; color: #555;">This site is protected by reCAPTCHA and the <a href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a> and <a href="https://policies.google.com/terms" target="_blank">Terms of Service</a> apply.</p>
    </div>

    <!-- بنر شناور ریکپچا در سمت راست صفحه -->
    <div class="recaptcha-badge-fixed">
        <div class="badge-logo">
            <img src="https://www.gstatic.com/recaptcha/api2/logo_48.png" alt="reCAPTCHA">
        </div>
        <div class="badge-text">
            protected by reCAPTCHA
        </div>
    </div>

</body>
</html>
