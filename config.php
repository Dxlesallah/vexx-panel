<?php
$servername = "localhost";
$username = "idXXXXX_vexx_panel";
$password = "XXXXX";
$dbname = "idXXXXX_vexx_panel";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}

// Mail ve kullanıcı adı kontrolü için ayarlar
$control_settings = [
    'block_duration' => 32 * 24 * 60 * 60, // 32 gün saniye cinsinden
    'mail_error_message' => 'Bu mail adresi ile son 32 gün içinde kayıt yapılmış. Lütfen başka bir mail adresi kullanın.',
    'username_error_message' => 'Bu kullanıcı adı ile son 32 gün içinde kayıt yapılmış. Lütfen başka bir kullanıcı adı seçin.'
];
?> 