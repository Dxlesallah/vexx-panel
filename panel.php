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
    <title>Panel - VEXX-PANEL</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #000;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: rgba(0, 0, 0, 0.9);
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: #fff;
            font-size: 24px;
        }

        .menu-button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .menu-line {
            width: 25px;
            height: 3px;
            background: #fff;
            transition: 0.3s;
        }

        .menu-button.active .menu-line:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }

        .menu-button.active .menu-line:nth-child(2) {
            opacity: 0;
        }

        .menu-button.active .menu-line:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
        }

        .sidebar {
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100vh;
            background: rgba(0, 0, 0, 0.95);
            padding: 80px 20px;
            transition: 0.3s;
            z-index: 1001;
        }

        .sidebar.active {
            right: 0;
        }

        .category {
            color: #fff;
            padding: 15px;
            margin: 5px 0;
            cursor: pointer;
            transition: 0.3s;
            border-radius: 5px;
        }

        .category:hover {
            background: rgba(255, 0, 0, 0.2);
        }

        .content {
            padding: 20px;
            color: #fff;
        }

        .logout-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: red;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .logout-btn:hover {
            background: #ff3333;
        }

        @media screen and (max-width: 768px) {
            .sidebar {
                width: 250px;
                right: -250px;
                padding: 60px 15px;
            }

            .category {
                padding: 12px;
                font-size: 14px;
            }

            .content {
                padding: 15px;
            }

            .content h1 {
                font-size: 20px;
            }

            .content p {
                font-size: 14px;
            }
        }

        @media screen and (max-width: 480px) {
            .sidebar {
                width: 200px;
                right: -200px;
                padding: 50px 10px;
            }

            .category {
                padding: 10px;
                font-size: 12px;
            }

            .content {
                padding: 10px;
            }

            .content h1 {
                font-size: 18px;
            }

            .content p {
                font-size: 12px;
            }

            .logo {
                font-size: 18px;
            }

            .menu-line {
                width: 20px;
                height: 2px;
            }
        }

        .music-control {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.8);
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 1000;
            border: 2px solid #ff0000;
            box-shadow: 0 0 10px #ff0000;
        }

        .music-control i {
            color: #fff;
            font-size: 24px;
        }

        .music-list {
            position: fixed;
            bottom: 120px;
            right: 20px;
            width: 300px;
            max-height: 300px;
            background: rgba(0, 0, 0, 0.9);
            border-radius: 10px;
            padding: 10px;
            display: none;
            overflow-y: auto;
            z-index: 1000;
            border: 2px solid #ff0000;
            box-shadow: 0 0 10px #ff0000;
        }

        .music-list.active {
            display: block;
        }

        .music-item {
            color: #fff;
            padding: 10px;
            margin: 5px 0;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .music-item:hover {
            background: rgba(255, 0, 0, 0.2);
        }

        .music-item.active {
            background: rgba(255, 0, 0, 0.3);
        }

        #audioPlayer {
            display: none;
        }

        .warning-text {
            position: fixed;
            top: 20px;
            left: 20px;
            font-size: 12px;
            color: #ff0000;
            font-family: Arial, sans-serif;
            text-shadow: 0 0 5px #ff0000;
            font-weight: bold;
            background: rgba(0, 0, 0, 0.8);
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid #ff0000;
            text-align: center;
            z-index: 2;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="navbar">
        <div class="warning-text">Bu siteyi kullanmak kendi riskinizdedir. Herhangi bir sorumluluk kabul etmiyorum.</div>
        <div class="logo">VEXX-PANEL</div>
        <button class="menu-button" onclick="toggleMenu()">
            <div class="menu-line"></div>
            <div class="menu-line"></div>
            <div class="menu-line"></div>
        </button>
    </div>

    <div class="sidebar">
        <div class="category">Kategori 1</div>
        <div class="category">Kategori 2</div>
        <div class="category">Kategori 3</div>
        <div class="category">Kategori 4</div>
        <div class="category">Kategori 5</div>
    </div>

    <div class="content">
        <h1>Ana Sayfa</h1>
        <p>Hoş geldin, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <p>Panel içeriği buraya gelecek...</p>
    </div>

    <button class="logout-btn" onclick="logout()">Çıkış Yap</button>

    <!-- Müzik Kontrolü -->
    <div class="music-control" onclick="toggleMusicList(event)">
        <i class="fas fa-music"></i>
    </div>

    <div class="music-list" id="musicList">
        <div class="music-item" onclick="playMusic('Uzi-Hisler-Gercek-Gulusler-Sahte-ft-Heijan-89.mp3')">Uzi x Heijan - Hisler Gerçek, Gülüşler Sahte</div>
        <div class="music-item" onclick="playMusic('-Uzi-Paparazzi-98.mp3')">Uzi - Paparazzi</div>
        <div class="music-item" onclick="playMusic('Jeff-Redd-PSYCHO-43.mp3')">Jeff Redd - PSYCHO</div>
        <div class="music-item" onclick="playMusic('Jeff Redd - O Adam feat Stabil (Official Audio) (1).mp3')">Jeff Redd - O Adam feat Stabil</div>
    </div>

    <audio id="audioPlayer" autoplay loop preload="auto">
        <source src="" type="audio/mpeg">
    </audio>

    <script>
        function toggleMenu() {
            document.querySelector('.menu-button').classList.toggle('active');
            document.querySelector('.sidebar').classList.toggle('active');
        }

        function logout() {
            window.location.href = 'logout.php';
        }

        // Şarkı listesi
        const songs = [
            { title: 'Uzi x Heijan - Hisler Gerçek, Gülüşler Sahte', path: 'Uzi-Hisler-Gercek-Gulusler-Sahte-ft-Heijan-89.mp3' },
            { title: 'Uzi - Paparazzi', path: '-Uzi-Paparazzi-98.mp3' },
            { title: 'Jeff Redd - PSYCHO', path: 'Jeff-Redd-PSYCHO-43.mp3' },
            { title: 'Jeff Redd - O Adam feat Stabil', path: 'Jeff Redd - O Adam feat Stabil (Official Audio) (1).mp3' }
        ];

        // Rastgele şarkı seçme fonksiyonu
        function getRandomSong() {
            const randomIndex = Math.floor(Math.random() * songs.length);
            return songs[randomIndex];
        }

        function toggleMusicList(event) {
            event.stopPropagation();
            const musicList = document.getElementById('musicList');
            musicList.classList.toggle('active');
        }

        function playMusic(songPath) {
            const audioPlayer = document.getElementById('audioPlayer');
            const musicItems = document.querySelectorAll('.music-item');
            
            // Tüm müzik öğelerinden active sınıfını kaldır
            musicItems.forEach(item => item.classList.remove('active'));
            
            // Tıklanan öğeye active sınıfını ekle
            event.target.classList.add('active');
            
            // Şarkıyı çal
            audioPlayer.src = songPath;
            audioPlayer.play();
            
            // Müzik listesini gizle
            document.getElementById('musicList').classList.remove('active');
        }

        // Sayfa yüklendiğinde
        document.addEventListener('DOMContentLoaded', function() {
            // Müzik kontrolünü göster
            document.querySelector('.music-control').style.display = 'block';
            
            // İlk şarkıyı rastgele seç ve çal
            const randomSong = getRandomSong();
            const audioPlayer = document.getElementById('audioPlayer');
            audioPlayer.src = randomSong.path;
            audioPlayer.load();
            
            // Kullanıcı etkileşimi sonrası müziği başlat
            document.body.addEventListener('click', function startMusic() {
                audioPlayer.play().catch(function(error) {
                    console.log("Müzik başlatma hatası:", error);
                });
                document.body.removeEventListener('click', startMusic);
            }, { once: true });
            
            // İlk şarkıyı aktif olarak işaretle
            const musicItems = document.querySelectorAll('.music-item');
            musicItems.forEach(item => {
                if (item.textContent === randomSong.title) {
                    item.classList.add('active');
                }
            });
        });

        // Şarkı bittiğinde yeni şarkı çal
        document.getElementById('audioPlayer').addEventListener('ended', function() {
            const randomSong = getRandomSong();
            playMusic(randomSong.path);
        });
    </script>
</body>
</html>
