<?php
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Veritabanı bağlantısı
    $db = new PDO("mysql:host=localhost;dbname=vexx_panel", "kullanici_adi", "sifre");
    
    // Token'ı kontrol et ve kullanıcıyı doğrula
    $stmt = $db->prepare("UPDATE users SET is_verified = 1 WHERE verification_token = ? AND is_verified = 0");
    $stmt->execute([$token]);
    
    if ($stmt->rowCount() > 0) {
        echo "<script>
            alert('Hesabınız başarıyla doğrulandı! Şimdi giriş yapabilirsiniz.');
            window.location.href = 'index.html';
        </script>";
    } else {
        echo "<script>
            alert('Geçersiz veya kullanılmış doğrulama bağlantısı!');
            window.location.href = 'index.html';
        </script>";
    }
} else {
    header("Location: index.html");
}
?> 