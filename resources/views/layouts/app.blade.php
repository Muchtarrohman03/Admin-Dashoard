<!DOCTYPE html >
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
        <title>@yield('title', config('app.name', 'Laravel'))</title>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body class="font-sans antialiased " x-data="{ scrolled: false }">
        <div class="min-h-screen bg-accent ">
            @include('layouts.navigation')

            <div class="flex items-center justify-center"></div>
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
   <script>
    // chart service controller
    async function loadChart() {
        const res = await fetch('/dashboard/chart-data');
        const result = await res.json();

        const ctx = document.getElementById('serviceChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: result.labels,
                datasets: [{
                    label: 'Jumlah Servis',
                    data: result.data,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }
    loadChart();

    // chart product controller
    
    async function loadProductPieChart() {
        const res = await fetch("{{ route('dashboard.product-stock') }}");
        const result = await res.json();

        const colors = result.labels.map(() => {
            return `hsl(${Math.floor(Math.random() * 360)}, 70%, 60%)`;
        });

        const ctx = document.getElementById('productPieChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: result.labels,
                datasets: [{
                    label: 'Stok Produk',
                    data: result.data,
                    backgroundColor: colors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    }

    loadProductPieChart();

    //chart order controller
     async function loadOrderChart() {
        const res = await fetch('{{ route("dashboard.order-chart") }}');
        const result = await res.json();

        const ctx = document.getElementById('orderChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: result.labels,
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: result.data,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    loadOrderChart();
</script>
    <x-footer></x-footer>
</html>
