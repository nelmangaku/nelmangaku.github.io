<?php
// Fungsi untuk mendapatkan informasi IP dan lokasi
function getClientInfo() {
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Jika menggunakan shared hosting, dapatkan IP asli pengguna
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    
    return [
        'ip' => $ip,
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'accept_language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '',
        'server_time' => date('Y-m-d H:i:s'),
        'timezone' => date_default_timezone_get()
    ];
}

$clientInfo = getClientInfo();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deteksi Perangkat Akurat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --accent: #4895ef;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
        }

        header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        header h1 i {
            margin-right: 10px;
        }

        .subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .last-update {
            font-size: 0.8rem;
            margin-top: 10px;
        }

        main {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            padding: 15px;
            background: linear-gradient(135deg, var(--accent), var(--primary));
            color: white;
            display: flex;
            align-items: center;
        }

        .card-header i {
            font-size: 1.2rem;
            margin-right: 10px;
        }

        .card-header h2 {
            font-size: 1.1rem;
        }

        .card-body {
            padding: 20px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #eee;
        }

        .info-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .label {
            font-weight: 500;
            color: #555;
            display: flex;
            align-items: center;
        }

        .label i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
            color: var(--primary);
        }

        .value {
            font-weight: 600;
            text-align: right;
            color: var(--dark);
            max-width: 60%;
            word-break: break-word;
        }

        footer {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            font-size: 0.85rem;
            color: #666;
        }

        @media (max-width: 768px) {
            main {
                grid-template-columns: 1fr;
            }
            
            .info-item {
                flex-direction: column;
            }
            
            .value {
                text-align: left;
                margin-top: 5px;
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            header h1 {
                font-size: 1.5rem;
            }
            
            .card-header h2 {
                font-size: 1rem;
            }
            
            .label, .value {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-fingerprint"></i> Informasi Perangkat</h1>
            <p class="subtitle">Deteksi akurat perangkat dan lokasi Anda</p>
            <div class="last-update">Waktu Server: <?php echo $clientInfo['server_time']; ?></div>
        </header>

        <main>
            <section class="card device-info">
                <div class="card-header">
                    <i class="fas fa-mobile-alt"></i>
                    <h2>Informasi Perangkat</h2>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <span class="label"><i class="fas fa-desktop"></i> User Agent:</span>
                        <span id="user-agent" class="value"><?php echo htmlspecialchars($clientInfo['user_agent']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label"><i class="fas fa-language"></i> Bahasa:</span>
                        <span id="language" class="value"><?php echo htmlspecialchars($clientInfo['accept_language']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label"><i class="fab fa-android"></i> OS:</span>
                        <span id="os" class="value">Mendeteksi...</span>
                    </div>
                    <div class="info-item">
                        <span class="label"><i class="fas fa-globe"></i> Browser:</span>
                        <span id="browser" class="value">Mendeteksi...</span>
                    </div>
                    <div class="info-item">
                        <span class="label"><i class="fas fa-expand"></i> Layar:</span>
                        <span id="screen" class="value">Mendeteksi...</span>
                    </div>
                </div>
            </section>

            <section class="card network-info">
                <div class="card-header">
                    <i class="fas fa-network-wired"></i>
                    <h2>Informasi Jaringan</h2>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <span class="label"><i class="fas fa-address-card"></i> IP Address:</span>
                        <span id="ip" class="value"><?php echo htmlspecialchars($clientInfo['ip']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label"><i class="fas fa-wifi"></i> Tipe Koneksi:</span>
                        <span id="connection" class="value">Mendeteksi...</span>
                    </div>
                    <div class="info-item">
                        <span class="label"><i class="fas fa-tachometer-alt"></i> Kecepatan:</span>
                        <span id="network-speed" class="value">Mendeteksi...</span>
                    </div>
                    <div class="info-item">
                        <span class="label"><i class="fas fa-server"></i> Lokasi Server:</span>
                        <span id="server-location" class="value"><?php echo htmlspecialchars($clientInfo['timezone']); ?></span>
                    </div>
                </div>
            </section>

            <section class="card location-info">
                <div class="card-header">
                    <i class="fas fa-map-marked-alt"></i>
                    <h2>Informasi Lokasi</h2>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <span class="label"><i class="fas fa-globe-americas"></i> Negara:</span>
                        <span id="country" class="value">Mendeteksi...</span>
                    </div>
                    <div class="info-item">
                        <span class="label"><i class="fas fa-city"></i> Kota:</span>
                        <span id="city" class="value">Mendeteksi...</span>
                    </div>
                    <div class="info-item">
                        <span class="label"><i class="fas fa-map-pin"></i> Koordinat:</span>
                        <span id="coordinates" class="value">Mendeteksi...</span>
                    </div>
                    <div class="info-item">
                        <span class="label"><i class="fas fa-clock"></i> Waktu Lokal:</span>
                        <span id="local-time" class="value">Mendeteksi...</span>
                    </div>
                </div>
            </section>
        </main>

        <footer>
            <p><i class="fas fa-shield-alt"></i> Data ini hanya digunakan untuk keperluan demonstrasi</p>
            <p>IP Anda: <?php echo htmlspecialchars($clientInfo['ip']); ?></p>
        </footer>
    </div>

    <script>
        // Fungsi untuk mendeteksi OS
        function detectOS() {
            const userAgent = navigator.userAgent;
            let os = "Tidak Diketahui";
            
            if (userAgent.match(/Android/i)) os = "Android";
            else if (userAgent.match(/iPhone|iPad|iPod/i)) os = "iOS";
            else if (userAgent.match(/Windows/i)) os = "Windows";
            else if (userAgent.match(/Macintosh|Mac OS X/i)) os = "MacOS";
            else if (userAgent.match(/Linux/i)) os = "Linux";
            
            document.getElementById('os').textContent = os;
        }

        // Fungsi untuk mendeteksi browser
        function detectBrowser() {
            const userAgent = navigator.userAgent;
            let browser = "Tidak Diketahui";
            
            if (userAgent.match(/Chrome/i) && !userAgent.match(/Edg/i)) browser = "Chrome";
            else if (userAgent.match(/Firefox/i)) browser = "Firefox";
            else if (userAgent.match(/Safari/i) && !userAgent.match(/Chrome/i)) browser = "Safari";
            else if (userAgent.match(/Edg/i)) browser = "Edge";
            else if (userAgent.match(/Opera|OPR/i)) browser = "Opera";
            else if (userAgent.match(/MSIE|Trident/i)) browser = "Internet Explorer";
            
            document.getElementById('browser').textContent = browser + " (v" + detectBrowserVersion() + ")";
        }

        // Mendeteksi versi browser
        function detectBrowserVersion() {
            const userAgent = navigator.userAgent;
            let temp;
            let version = "n/a";
            
            if ((temp = userAgent.match(/Chrome\/(\d+)/)) !== null) version = temp[1];
            else if ((temp = userAgent.match(/Firefox\/(\d+)/)) !== null) version = temp[1];
            else if ((temp = userAgent.match(/Version\/(\d+).*Safari/)) !== null) version = temp[1];
            else if ((temp = userAgent.match(/Edge\/(\d+)/)) !== null) version = temp[1];
            else if ((temp = userAgent.match(/OPR\/(\d+)/)) !== null) version = temp[1];
            else if ((temp = userAgent.match(/MSIE (\d+);/)) !== null) version = temp[1];
            
            return version;
        }

        // Mendeteksi resolusi layar
        function detectScreen() {
            const width = window.screen.width;
            const height = window.screen.height;
            const colorDepth = window.screen.colorDepth;
            document.getElementById('screen').textContent = `${width} × ${height} piksel, ${colorDepth}-bit`;
        }

        // Mendeteksi tipe koneksi
        function detectConnection() {
            const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
            let connectionType = "Tidak Diketahui";
            
            if (connection) {
                connectionType = connection.effectiveType || "n/a";
                if (connection.saveData) connectionType += " (Data Saver)";
                
                // Jika ada informasi kecepatan
                if (connection.downlink) {
                    document.getElementById('network-speed').textContent = `${connection.downlink} Mbps`;
                }
            }
            
            document.getElementById('connection').textContent = connectionType;
        }

        // Mendapatkan waktu lokal
        function updateLocalTime() {
            const now = new Date();
            const options = { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit',
                timeZoneName: 'short'
            };
            document.getElementById('local-time').textContent = now.toLocaleDateString('id-ID', options);
            setTimeout(updateLocalTime, 1000);
        }

        // Mendapatkan lokasi geografis
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude.toFixed(4);
                        const lng = position.coords.longitude.toFixed(4);
                        document.getElementById('coordinates').textContent = `${lat}, ${lng}`;
                        
                        // Reverse geocoding untuk mendapatkan alamat
                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.address) {
                                    if (data.address.country) {
                                        document.getElementById('country').textContent = data.address.country;
                                    }
                                    if (data.address.city || data.address.town || data.address.village) {
                                        document.getElementById('city').textContent = data.address.city || data.address.town || data.address.village;
                                    }
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    },
                    (error) => {
                        console.error("Error getting location:", error);
                        getLocationFromIP();
                    }
                );
            } else {
                getLocationFromIP();
            }
        }

        // Fallback: Mendapatkan lokasi dari IP jika GPS tidak tersedia
        function getLocationFromIP() {
            fetch('https://ipapi.co/json/')
                .then(response => response.json())
                .then(data => {
                    if (data.country_name) {
                        document.getElementById('country').textContent = data.country_name;
                    }
                    if (data.city) {
                        document.getElementById('city').textContent = data.city;
                    }
                    if (data.latitude && data.longitude) {
                        document.getElementById('coordinates').textContent = `${data.latitude}, ${data.longitude}`;
                    }
                    if (data.timezone) {
                        document.getElementById('local-time').textContent = new Date().toLocaleString('id-ID', { timeZone: data.timezone });
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Inisialisasi semua deteksi saat halaman dimuat
        window.onload = function() {
            detectOS();
            detectBrowser();
            detectScreen();
            detectConnection();
            updateLocalTime();
            getLocation();
        };
    </script>
</body>
</html>