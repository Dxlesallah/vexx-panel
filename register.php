<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    try {
        // Mail kontrolü
        $check_mail_stmt = $conn->prepare("SELECT register_date FROM users WHERE email = ? ORDER BY register_date DESC LIMIT 1");
        $check_mail_stmt->execute([$email]);
        $last_mail_register = $check_mail_stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($last_mail_register) {
            $last_register_time = strtotime($last_mail_register['register_date']);
            $current_time = time();
            $time_diff = $current_time - $last_register_time;
            
            if ($time_diff < $control_settings['block_duration']) {
                echo $control_settings['mail_error_message'];
                exit();
            }
        }

        // Kullanıcı adı kontrolü
        $check_username_stmt = $conn->prepare("SELECT register_date FROM users WHERE username = ? ORDER BY register_date DESC LIMIT 1");
        $check_username_stmt->execute([$username]);
        $last_username_register = $check_username_stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($last_username_register) {
            $last_register_time = strtotime($last_username_register['register_date']);
            $current_time = time();
            $time_diff = $current_time - $last_register_time;
            
            if ($time_diff < $control_settings['block_duration']) {
                echo $control_settings['username_error_message'];
                exit();
            }
        }
        
        // Kullanıcıyı veritabanına ekle
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, register_date) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$username, $email, $password]);
        
        // Hoş geldin maili gönder
        $message = "
        <html>
        <head>
            <title>VEXX-PANEL'e Hoş Geldiniz</title>
        </head>
        <body>
            <h2>Merhaba $username,</h2>
            <p>VEXX-PANEL'e hoş geldiniz!</p>
            <p>Hesabınız başarıyla oluşturuldu.</p>
            <p>Hesabınız 32 gün boyunca aktif kalacaktır.</p>
            <p>İyi kullanımlar dileriz.</p>
            <br>
            <p>Saygılarımızla,<br>VEXX-PANEL Ekibi</p>
        </body>
        </html>
        ";
        
        // Mail gönder
        mail($email, $mail_settings['subject'], $message, $mail_settings['headers']);
        
        // Başarılı kayıt sonrası yönlendirme
        header("Location: welcome.php");
        exit();
    } catch(PDOException $e) {
        echo "Kayıt hatası: " . $e->getMessage();
    }
}
?> 