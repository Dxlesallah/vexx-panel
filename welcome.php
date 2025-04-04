<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoşgeldin - VEXX-PANEL</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }

        .welcome-container {
            text-align: center;
            color: #fff;
        }

        .welcome-text {
            font-size: 45px;
            color: #ffffff;
            font-weight: 900;
            letter-spacing: 4px;
            background: rgba(0, 0, 0, 0.8);
            padding: 20px 40px;
            border-radius: 10px;
            border: 2px solid #ff0000;
            box-shadow: 0 0 10px #ff0000,
                       0 0 20px #ff0000,
                       0 0 30px #ff0000;
            animation: neonGlow 2s ease-in-out infinite alternate;
        }

        .developer-text {
            margin-top: 20px;
            font-size: 16px;
            color: #ff0000;
            font-weight: bold;
        }

        @keyframes neonGlow {
            from {
                box-shadow: 0 0 10px #ff0000,
                           0 0 20px #ff0000,
                           0 0 30px #ff0000;
            }
            to {
                box-shadow: 0 0 20px #ff0000,
                           0 0 30px #ff0000,
                           0 0 40px #ff0000;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-text">HOŞGELDİN</div>
        <div class="developer-text">developed by dxles</div>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = 'panel.php';
        }, 4000);
    </script>
</body>
</html>
