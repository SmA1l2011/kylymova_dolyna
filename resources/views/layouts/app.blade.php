<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Класичні турецькі килими для затишку та стилю</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <script>
            window.dataLayer = window.dataLayer || [];
        </script>
        <!-- Google Tag Manager -->
        <script>
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-XXXXXX');
        </script>
        <!-- End Google Tag Manager -->

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-12345678" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                @if (explode("/", request()->url())[5] === "site")
                    @include('layouts.navigation')
                @else
                    @include('layouts.navigationAdmin')
                @endif
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset
        
        <!-- Page Content -->
        <main>
            <div class="bg-block min-h-screen bg-gray-100 dark:bg-gray-900">
                {{ $slot }}
            </div>
        </main>
        <footer>
            <div class="wrapper flex">
                <a class="tel" href="tel:+380 67 282 20 41">+380 67 282 20 41</a>
                <div class="info">
                    <p class="copy">&copy; 2026 kylymova_dolyna. Всі права захищені.</p>
                    <p class="developer">Розробка сайту - <a href="https://t.me/SmA1l2011" target="_blank">@SmA1l2011</a></p>
                </div>
                <div class="social-media">
                    <a class="inst" href="https://instagram.com/kylymova_dolyna" target="_blank"></a>
                    <a class="fb" href="https://facebook.com/sasa.petak.2025" target="_blank"></a>
                    <a class="vb" href="viber://chat?number=+380672822041" target="_blank"></a>
                    <a class="tg" href="https://t.me/SHAMAN1298" target="_blank"></a>
                </div>
            </div>
        </footer>
    </body>
</html>
