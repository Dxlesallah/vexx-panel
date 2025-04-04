<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: welcome.php");
                exit();
            }
        }
        
        echo "<script>
            alert('Kullanıcı adı veya şifre hatalı!');
            window.location.href = 'index.html';
        </script>";
    } catch(PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
}
?> 