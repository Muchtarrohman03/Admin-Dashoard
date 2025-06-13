<!DOCTYPE html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
     x-data="{ theme: localStorage.getItem('theme') || 'light' }" :data-theme="theme" 
     x-init="$watch('theme', val => localStorage.setItem('theme', val))">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Swiper CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased " x-data="{ scrolled: false }" 
      @scroll.window="scrolled = (window.pageYOffset > 50) ? true : false">
        <div class="min-h-screen bg-accent ">
            @include('layouts.navpreview')

            <div class="flex items-center justify-center"></div>
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
              <x-footer></x-footer>
        </div>
      
    </body>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: {
            slidesPerView: 2,
            spaceBetween: 20,
            },
            1024: {
            slidesPerView: 3,
            spaceBetween: 30,
            },
        },
        });

    </script>


</html>
