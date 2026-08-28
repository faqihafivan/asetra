<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'ASETRA') }} — Masuk</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800&display=swap" rel="stylesheet"/>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            * { font-family: 'Plus Jakarta Sans', sans-serif; }

            html, body { height: 100%; overflow: hidden; margin: 0; padding: 0; }

            /* Animated gradient background */
            .bg-animated {
                background: linear-gradient(-45deg, #1e40af, #3b82f6, #6366f1, #8b5cf6, #2563eb);
                background-size: 400% 400%;
                animation: gradientShift 12s ease infinite;
            }
            @keyframes gradientShift {
                0%   { background-position: 0% 50%; }
                50%  { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            /* Floating blobs */
            .blob-1 {
                position: absolute;
                width: 500px; height: 500px;
                background: rgba(99, 102, 241, 0.35);
                border-radius: 73% 27% 60% 40% / 40% 55% 45% 60%;
                top: -120px; left: -100px;
                animation: morphBlob1 14s ease-in-out infinite;
                filter: blur(2px);
            }
            .blob-2 {
                position: absolute;
                width: 420px; height: 420px;
                background: rgba(139, 92, 246, 0.3);
                border-radius: 40% 60% 30% 70% / 60% 40% 70% 30%;
                bottom: -80px; right: -80px;
                animation: morphBlob2 18s ease-in-out infinite;
                filter: blur(2px);
            }
            .blob-3 {
                position: absolute;
                width: 280px; height: 280px;
                background: rgba(37, 99, 235, 0.25);
                border-radius: 60% 40% 50% 50% / 50% 60% 40% 50%;
                bottom: 10%; left: 10%;
                animation: morphBlob1 20s ease-in-out infinite reverse;
                filter: blur(3px);
            }
            @keyframes morphBlob1 {
                0%,100% { border-radius: 73% 27% 60% 40%/40% 55% 45% 60%; transform: translate(0,0) rotate(0deg); }
                33%     { border-radius: 40% 60% 70% 30%/50% 30% 70% 50%; transform: translate(20px,-30px) rotate(5deg); }
                66%     { border-radius: 50% 50% 30% 70%/60% 40% 60% 40%; transform: translate(-15px, 20px) rotate(-3deg); }
            }
            @keyframes morphBlob2 {
                0%,100% { border-radius: 40% 60% 30% 70%/60% 40% 70% 30%; transform: translate(0,0) rotate(0deg); }
                33%     { border-radius: 70% 30% 60% 40%/40% 70% 30% 60%; transform: translate(-25px, 15px) rotate(-6deg); }
                66%     { border-radius: 30% 70% 40% 60%/50% 50% 50% 50%; transform: translate(10px,-20px) rotate(4deg); }
            }

            /* Wave SVG at bottom */
            .wave-container {
                position: absolute;
                bottom: 0; left: 0; right: 0;
                pointer-events: none;
            }

            /* Dots pattern */
            .dots-pattern {
                position: absolute;
                inset: 0;
                background-image: radial-gradient(rgba(255,255,255,0.12) 1px, transparent 1px);
                background-size: 30px 30px;
            }

            /* Card glassmorphism */
            .login-card {
                background: rgba(255, 255, 255, 0.97);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.5);
                box-shadow:
                    0 25px 60px rgba(0, 0, 0, 0.25),
                    0 0 0 1px rgba(255,255,255,0.1),
                    inset 0 1px 0 rgba(255,255,255,0.8);
            }

            /* Floating particles */
            .particle {
                position: absolute;
                background: rgba(255,255,255,0.15);
                border-radius: 50%;
                animation: floatParticle linear infinite;
            }
            @keyframes floatParticle {
                0%   { transform: translateY(0) rotate(0deg); opacity: 0; }
                10%  { opacity: 1; }
                90%  { opacity: 1; }
                100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; }
            }

            /* Card entrance animation */
            .card-enter {
                animation: cardEnter 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) both;
            }
            @keyframes cardEnter {
                from { opacity: 0; transform: translateY(40px) scale(0.95); }
                to   { opacity: 1; transform: translateY(0) scale(1); }
            }
        </style>
    </head>
    <body class="h-full overflow-hidden">

        {{-- ===== BACKGROUND ===== --}}
        <div class="bg-animated fixed inset-0">

            {{-- Blobs --}}
            <div class="blob-1"></div>
            <div class="blob-2"></div>
            <div class="blob-3"></div>

            {{-- Dots --}}
            <div class="dots-pattern"></div>

            {{-- Particles --}}
            <div class="particle w-2 h-2" style="left:10%; animation-duration:8s; animation-delay:0s;"></div>
            <div class="particle w-3 h-3" style="left:25%; animation-duration:11s; animation-delay:2s;"></div>
            <div class="particle w-1.5 h-1.5" style="left:40%; animation-duration:9s; animation-delay:4s;"></div>
            <div class="particle w-2.5 h-2.5" style="left:60%; animation-duration:13s; animation-delay:1s;"></div>
            <div class="particle w-2 h-2" style="left:75%; animation-duration:10s; animation-delay:3s;"></div>
            <div class="particle w-1 h-1" style="left:88%; animation-duration:12s; animation-delay:5s;"></div>

            {{-- Wave bottom --}}
            <div class="wave-container">
                <svg viewBox="0 0 1440 200" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full" style="height:160px;">
                    <path fill="rgba(255,255,255,0.05)" d="M0,80 C240,160 480,0 720,80 C960,160 1200,0 1440,80 L1440,200 L0,200 Z"/>
                    <path fill="rgba(255,255,255,0.07)" d="M0,100 C180,30 360,150 540,100 C720,50 900,150 1080,100 C1260,50 1380,120 1440,100 L1440,200 L0,200 Z"/>
                    <path fill="rgba(255,255,255,0.04)" d="M0,130 C300,70 600,170 900,130 C1100,105 1300,155 1440,130 L1440,200 L0,200 Z"/>
                </svg>
            </div>

            {{-- Top-right decorative ring --}}
            <div class="absolute top-8 right-12 w-32 h-32 rounded-full border-2 border-white/10"></div>
            <div class="absolute top-12 right-16 w-20 h-20 rounded-full border border-white/10"></div>

            {{-- Bottom-left decorative --}}
            <div class="absolute bottom-16 left-8 w-24 h-24 rounded-full border-2 border-white/10"></div>
        </div>

        {{-- ===== CENTER CARD ===== --}}
        <div class="fixed inset-0 flex items-center justify-center px-4">
            <div class="login-card card-enter w-full max-w-sm rounded-3xl overflow-hidden">

                {{-- Card top accent bar --}}
                <div class="h-1.5 bg-gradient-to-r from-blue-500 via-indigo-500 to-violet-500"></div>

                <div class="px-7 py-6">
                    {{ $slot }}
                </div>
            </div>
        </div>

        {{-- Branding watermark bottom --}}
        <div class="fixed bottom-4 left-0 right-0 text-center pointer-events-none">
            <p class="text-white/40 text-xs tracking-wide">© {{ date('Y') }} ASETRA · Asset & Inventory Management System</p>
        </div>

    </body>
</html>
