@php
    $user = Auth::user();

    $menus = [];

    if ($user->hasRole('admin')) {
        $menus[] = ['label' => 'Produk', 'route' => 'admin.product'];
        $menus[] = ['label' => 'Servis', 'route' => 'admin.services'];
        $menus[] = ['label' => 'Pesanan', 'route' => 'admin.orders'];
    }
    if($user->hasRole('administrator')){
        $menus[] = ['label' => 'Produk', 'route' => 'admin.product'];
        $menus[] = ['label' => 'Servis', 'route' => 'admin.services'];
        $menus[] = ['label' => 'Pesanan', 'route' => 'admin.orders'];
        $menus[] = ['label' => 'Users', 'route' => 'admin.users'];
    }

    if ($user->hasRole('pimpinan')) {
        $menus[] = ['label' => 'Product', 'route' => 'product.index'];
        $menus[] = ['label' => 'Services', 'route' => 'services.index'];
        $menus[] = ['label' => 'Orders', 'route' => 'orders.index'];
        $menus[] = ['label' => 'Users', 'route' => 'admin.users'];
    }

    array_unshift($menus, ['label' => 'Dashboard', 'route' => 'dashboard']);
@endphp

<!-- Navbar -->
    <nav class="fixed w-full transition-all duration-300 z-50" 
            x-data="{ open: false }"
           x-data="{ scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
    class="fixed inset-x-0 top-0 z-50 transition-all duration-300">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 transition-all duration-500 ease-in-out"
         :class="scrolled 
            ? 'bg-base-200/60 shadow-md mt-2 py-3 backdrop-blur-sm rounded-xl' 
            : 'bg-transparent py-4'">

            <div class="flex justify-between items-center">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}">
                            <img src="{{url('IKK-1-removebg-preview.png')}}" class="w-12 h-12"  alt="">
                        </a>
                    </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:-my-px sm:ms-10 space-x-8" :class="scrolled ? 'text-secondary' : 'text-gray-500'">
                    @foreach ($menus as $menu)
                        <x-nav-link :href="route($menu['route'])" :active="request()->routeIs($menu['route'])">
                            {{ __($menu['label']) }}
                        </x-nav-link>
                    @endforeach
                </div>
                </div>
                <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2  text-sm leading-4 font-medium rounded-md text-gray-500 bg-transparent hover:bg-base-200/60 hover:text-primary focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>  
                <div class="flex mx-2">
                <x-lightdark-toggle></x-lightdark-toggle>
                </div>
            </div>
                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400
                    hover:text-gray-500 hover:bg-accent focus:outline-none focus:bg-accent focus:text-gray-500 transition 
                    duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
            <!-- Responsive Navigation Menu -->
    <div 
    x-show="open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-y-5"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-5"
    class="sm:hidden shadow-md bg-base-100/60 backdrop-blur-sm  origin-top"
    @click.outside="open = false"
    >
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('product.index')" :active="request()->routeIs('product.index')">
                {{ __('Product') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('services.index')" :active="request()->routeIs('services.index')">
                {{ __('Service') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                {{ __('Pesanan') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            <div class=" flex px-4 py-2">
                <x-lightdark-toggle></x-lightdark-toggle>
                <p class="bg-grey-400 ml-1">Mode</p>
            </div>
        </div>
    </div>
    </nav>
