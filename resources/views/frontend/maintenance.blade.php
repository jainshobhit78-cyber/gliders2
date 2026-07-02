<?php
$settings = \App\Models\GeneralSetting::first();
$maintenanceUntil = $settings?->maintenance_until;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode - Gliders India</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #0b2a5b 0%, #081d40 100%);
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow: hidden;
        }
        .container {
            max-width: 600px;
            padding: 40px 20px;
            z-index: 2;
        }
        .logo {
            max-width: 180px;
            margin-bottom: 30px;
            animation: pulse 2.5s infinite ease-in-out;
        }
        h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }
        h1 span {
            color: #f5821f;
        }
        p {
            font-size: 1.2rem;
            color: #a5b4fc;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .status-badge {
            display: inline-block;
            background: rgba(245, 130, 31, 0.15);
            border: 1px solid rgba(245, 130, 31, 0.3);
            color: #f5821f;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .countdown-wrapper {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 2.5rem 0;
        }
        .time-block {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 12px;
            border-radius: 16px;
            min-width: 80px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            backdrop-filter: blur(15px);
            transition: transform 0.3s;
        }
        .time-block:hover {
            transform: translateY(-5px);
        }
        .time-block span {
            display: block;
            font-size: 2.4rem;
            font-weight: 900;
            color: #f5821f;
            line-height: 1;
        }
        .time-block label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #94a3b8;
            margin-top: 8px;
            display: block;
        }
        .footer {
            margin-top: 3rem;
            font-size: 0.85rem;
            color: #64748b;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.03); }
        }
        @media (max-width: 480px) {
            h1 { font-size: 2.2rem; }
            .time-block { min-width: 65px; padding: 10px 5px; }
            .time-block span { font-size: 1.8rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="/frontend/images/logo/g.png" alt="Gliders Logo" class="logo" style="width: 80px; border-radius: 50px;">
        <div class="status-badge">System Upgrades In Progress</div>
        <h1>We'll be <span>Back Soon</span></h1>
        <p>Gliders India website is temporarily undergoing scheduled maintenance to upgrade our systems and improve security. We apologize for any inconvenience caused.</p>

        @if($maintenanceUntil)
            <div id="countdown" class="countdown-wrapper" data-until="{{ \Carbon\Carbon::parse($maintenanceUntil)->toIso8601String() }}">
                <div class="time-block">
                    <span id="days">00</span>
                    <label>Days</label>
                </div>
                <div class="time-block">
                    <span id="hours">00</span>
                    <label>Hours</label>
                </div>
                <div class="time-block">
                    <span id="minutes">00</span>
                    <label>Mins</label>
                </div>
                <div class="time-block">
                    <span id="seconds">00</span>
                    <label>Secs</label>
                </div>
            </div>
        @endif

        <div class="footer">
            &copy; {{ date('Y') }} Gliders India Limited. All Rights Reserved.
        </div>
    </div>

    @if($maintenanceUntil)
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const countdownEl = document.getElementById("countdown");
            const targetDateStr = countdownEl.getAttribute("data-until");
            const targetDate = new Date(targetDateStr).getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const difference = targetDate - now;

                if (difference <= 0) {
                    clearInterval(intervalId);
                    countdownEl.innerHTML = "<div class='time-block' style='min-width: 250px;'><span>Back Shortly</span><label>Maintenance completed</label></div>";
                    return;
                }

                const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                document.getElementById("days").innerText = String(days).padStart(2, '0');
                document.getElementById("hours").innerText = String(hours).padStart(2, '0');
                document.getElementById("minutes").innerText = String(minutes).padStart(2, '0');
                document.getElementById("seconds").innerText = String(seconds).padStart(2, '0');
            }

            updateCountdown();
            const intervalId = setInterval(updateCountdown, 1000);
        });
    </script>
    @endif
</body>
</html>
