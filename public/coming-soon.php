<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon - MGF Việt Nam</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'SVN-Gotham', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 50%, #68a83f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Animated background circles */
        body::before,
        body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 20s infinite ease-in-out;
        }

        body::before {
            width: 400px;
            height: 400px;
            top: -200px;
            left: -200px;
            animation-delay: 0s;
        }

        body::after {
            width: 600px;
            height: 600px;
            bottom: -300px;
            right: -300px;
            animation-delay: 5s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -30px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .container {
            max-width: 800px;
            width: 100%;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .logo {
            margin-bottom: 40px;
            animation: fadeInDown 1s ease-out;
        }

        .logo img {
            max-width: 200px;
            height: auto;
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.05);
        }

        .content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 60px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease-out 0.3s both;
        }

        h1 {
            font-size: 48px;
            color: #333;
            margin-bottom: 20px;
            font-weight: bold;
            background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 50%, #68a83f 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            font-size: 24px;
            color: #666;
            margin-bottom: 30px;
            font-weight: 500;
        }

        .description {
            font-size: 16px;
            color: #777;
            line-height: 1.8;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .icon-wrapper {
            margin-bottom: 30px;
        }

        .icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            position: relative;
            animation: pulse 2s infinite ease-in-out;
        }

        .icon svg {
            width: 100%;
            height: 100%;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        .countdown {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .countdown-item {
            background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 50%, #68a83f 100%);
            padding: 20px;
            border-radius: 15px;
            min-width: 100px;
            color: white;
            box-shadow: 0 10px 30px rgba(45, 80, 22, 0.3);
            transition: transform 0.3s ease;
        }

        .countdown-item:hover {
            transform: translateY(-5px);
        }

        .countdown-number {
            font-size: 36px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .countdown-label {
            font-size: 14px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-home {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 50%, #68a83f 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(45, 80, 22, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-home::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.5s ease;
        }

        .btn-home:hover::before {
            left: 100%;
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(45, 80, 22, 0.4);
        }

        .social-links {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .social-link {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4a7c2c;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 24px;
        }

        .social-link:hover {
            background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 50%, #68a83f 100%);
            color: white;
            transform: translateY(-5px);
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .content {
                padding: 40px 20px;
            }

            h1 {
                font-size: 36px;
            }

            .subtitle {
                font-size: 20px;
            }

            .countdown {
                gap: 15px;
            }

            .countdown-item {
                min-width: 80px;
                padding: 15px;
            }

            .countdown-number {
                font-size: 28px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 28px;
            }

            .subtitle {
                font-size: 18px;
            }

            .description {
                font-size: 14px;
            }

            .countdown-item {
                min-width: 70px;
                padding: 12px;
            }

            .countdown-number {
                font-size: 24px;
            }

            .countdown-label {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="05_images/logo-GMF.png" alt="MGF Việt Nam">
        </div>

        <div class="content">
            <div class="icon-wrapper">
                <div class="icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="url(#gradient)" stroke-width="2"/>
                        <path d="M12 6V12L16 14" stroke="url(#gradient)" stroke-width="2" stroke-linecap="round"/>
                        <defs>
                            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#2d5016;stop-opacity:1" />
                                <stop offset="50%" style="stop-color:#4a7c2c;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#68a83f;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
            </div>

            <h1>Sắp ra mắt</h1>
            <p class="subtitle">Chúng tôi đang hoàn thiện trang này</p>
            <p class="description">
                Tính năng này đang được phát triển để mang đến trải nghiệm tốt nhất cho bạn. 
                Vui lòng quay lại sau hoặc truy cập trang chủ để khám phá các nội dung khác.
            </p>

            <div class="countdown">
                <div class="countdown-item">
                    <span class="countdown-number" id="days">00</span>
                    <span class="countdown-label">Ngày</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-number" id="hours">00</span>
                    <span class="countdown-label">Giờ</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-number" id="minutes">00</span>
                    <span class="countdown-label">Phút</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-number" id="seconds">00</span>
                    <span class="countdown-label">Giây</span>
                </div>
            </div>

            <a href="trang-chu" class="btn-home">
                <span>← Về Trang Chủ</span>
            </a>

            <div class="social-links">
                <a href="#" class="social-link" title="Facebook">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                <a href="#" class="social-link" title="YouTube">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </a>
                <a href="#" class="social-link" title="LinkedIn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Countdown timer
        const targetDate = new Date();
        targetDate.setDate(targetDate.getDate() + 30); // 30 days from now

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = String(days).padStart(2, '0');
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');

            if (distance < 0) {
                document.getElementById('days').textContent = '00';
                document.getElementById('hours').textContent = '00';
                document.getElementById('minutes').textContent = '00';
                document.getElementById('seconds').textContent = '00';
            }
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>
</body>
</html>
