<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
     x-data="{ theme: localStorage.getItem('theme') || 'light' }" :data-theme="theme" 
     x-init="$watch('theme', val => localStorage.setItem('theme', val))">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

         <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans bg-accent antialiased relative">
        <div class="absolute top-4 right-5 z-50">
            <x-lightdark-toggle></x-lightdark-toggle>
        </div>
        <div class=" min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 ">
            <div class="items-center justify-center">
                <a href="/">
                    <img src="{{url('IKK-1-removebg-preview.png')}}" height="50px" width="70px"  alt="">
                </a>
            </div>
            <h1 class=" text-base text-center  py-3  lg:text-2xl font-bold text-primary">Sistem Informasi Manajemen Pengelolaan Fiber Optic PT.Indo Karya Komunika</h1>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-base-100 shadow-md hover:shadow-primary overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
