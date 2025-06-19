@section('title', 'Dashboard')
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mt-10 mx-auto sm:px-6 lg:px-8">
            <div class="bg-base-100/60 backdrop-blur overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-secondary font-bold text-xl">
                    {{ __("Selamat Datang ". Auth::user()->name)."👋" }}
                </div>
            </div>
            {{-- Stat terkini --}}
            <section class="container mt-5 mx-auto mb-8">
                <h1 class="text-start mx-2 text-lg font-bold text-secondary my-2 lg:mx-0">Stat Terkini :</h1>
                <div class="grid mx-2 grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 lg:mx-0">
                    <div class="w-full bg-info rounded-lg py-6">
                        {{-- jumlah produk --}}
                        <h2 class="text-start text-base text-secondary font-bold mx-2 ">Jumlah Produk :</h2>
                        <div class="flex justify-between mx-2 ">
                            <p class="text-5xl font-extrabold text-secondary">{{$data['jmlProduk']}}</p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="35px" class="fill-current text-secondary " height="35px" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M50.7 58.5L0 160l208 0 0-128L93.7 32C75.5 32 58.9 42.3 50.7 58.5zM240 160l208 0L397.3 58.5C389.1 42.3 372.5 32 354.3 32L240 32l0 128zm208 32L0 192 0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-224z"/></svg>
                        </div>
                    </div>
                    {{-- jumlah servis --}}
                    <div class="w-full bg-warning rounded-lg py-6">
                        <h2 class="text-start text-base text-secondary font-bold mx-2 ">Jumlah Servis :</h2>
                        <div class="flex justify-between mx-2 ">
                            <p class="text-5xl font-extrabold text-secondary">{{$data['jmlServis']}}</p>
                           <svg xmlns="http://www.w3.org/2000/svg" width="35px" class="fill-current text-secondary" height="35px" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M308.5 135.3c7.1-6.3 9.9-16.2 6.2-25c-2.3-5.3-4.8-10.5-7.6-15.5L304 89.4c-3-5-6.3-9.9-9.8-14.6c-5.7-7.6-15.7-10.1-24.7-7.1l-28.2 9.3c-10.7-8.8-23-16-36.2-20.9L199 27.1c-1.9-9.3-9.1-16.7-18.5-17.8C173.9 8.4 167.2 8 160.4 8l-.7 0c-6.8 0-13.5 .4-20.1 1.2c-9.4 1.1-16.6 8.6-18.5 17.8L115 56.1c-13.3 5-25.5 12.1-36.2 20.9L50.5 67.8c-9-3-19-.5-24.7 7.1c-3.5 4.7-6.8 9.6-9.9 14.6l-3 5.3c-2.8 5-5.3 10.2-7.6 15.6c-3.7 8.7-.9 18.6 6.2 25l22.2 19.8C32.6 161.9 32 168.9 32 176s.6 14.1 1.7 20.9L11.5 216.7c-7.1 6.3-9.9 16.2-6.2 25c2.3 5.3 4.8 10.5 7.6 15.6l3 5.2c3 5.1 6.3 9.9 9.9 14.6c5.7 7.6 15.7 10.1 24.7 7.1l28.2-9.3c10.7 8.8 23 16 36.2 20.9l6.1 29.1c1.9 9.3 9.1 16.7 18.5 17.8c6.7 .8 13.5 1.2 20.4 1.2s13.7-.4 20.4-1.2c9.4-1.1 16.6-8.6 18.5-17.8l6.1-29.1c13.3-5 25.5-12.1 36.2-20.9l28.2 9.3c9 3 19 .5 24.7-7.1c3.5-4.7 6.8-9.5 9.8-14.6l3.1-5.4c2.8-5 5.3-10.2 7.6-15.5c3.7-8.7 .9-18.6-6.2-25l-22.2-19.8c1.1-6.8 1.7-13.8 1.7-20.9s-.6-14.1-1.7-20.9l22.2-19.8zM112 176a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zM504.7 500.5c6.3 7.1 16.2 9.9 25 6.2c5.3-2.3 10.5-4.8 15.5-7.6l5.4-3.1c5-3 9.9-6.3 14.6-9.8c7.6-5.7 10.1-15.7 7.1-24.7l-9.3-28.2c8.8-10.7 16-23 20.9-36.2l29.1-6.1c9.3-1.9 16.7-9.1 17.8-18.5c.8-6.7 1.2-13.5 1.2-20.4s-.4-13.7-1.2-20.4c-1.1-9.4-8.6-16.6-17.8-18.5L583.9 307c-5-13.3-12.1-25.5-20.9-36.2l9.3-28.2c3-9 .5-19-7.1-24.7c-4.7-3.5-9.6-6.8-14.6-9.9l-5.3-3c-5-2.8-10.2-5.3-15.6-7.6c-8.7-3.7-18.6-.9-25 6.2l-19.8 22.2c-6.8-1.1-13.8-1.7-20.9-1.7s-14.1 .6-20.9 1.7l-19.8-22.2c-6.3-7.1-16.2-9.9-25-6.2c-5.3 2.3-10.5 4.8-15.6 7.6l-5.2 3c-5.1 3-9.9 6.3-14.6 9.9c-7.6 5.7-10.1 15.7-7.1 24.7l9.3 28.2c-8.8 10.7-16 23-20.9 36.2L315.1 313c-9.3 1.9-16.7 9.1-17.8 18.5c-.8 6.7-1.2 13.5-1.2 20.4s.4 13.7 1.2 20.4c1.1 9.4 8.6 16.6 17.8 18.5l29.1 6.1c5 13.3 12.1 25.5 20.9 36.2l-9.3 28.2c-3 9-.5 19 7.1 24.7c4.7 3.5 9.5 6.8 14.6 9.8l5.4 3.1c5 2.8 10.2 5.3 15.5 7.6c8.7 3.7 18.6 .9 25-6.2l19.8-22.2c6.8 1.1 13.8 1.7 20.9 1.7s14.1-.6 20.9-1.7l19.8 22.2zM464 304a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>
                        </div>
                    </div>
                    {{-- jumlah pesanan --}}
                    <div class="w-full bg-success rounded-lg py-6">
                        <h2 class="text-start text-base text-secondary font-bold mx-2 ">Jumlah Pesanan :</h2>
                        <div class="flex justify-between mx-2 ">
                            <p class="text-5xl font-extrabold text-secondary">{{$data['jmlPesanan']}}</p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="35px" class="fill-current text-secondary" height="35px" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M58.9 42.1c3-6.1 9.6-9.6 16.3-8.7L320 64 564.8 33.4c6.7-.8 13.3 2.7 16.3 8.7l41.7 83.4c9 17.9-.6 39.6-19.8 45.1L439.6 217.3c-13.9 4-28.8-1.9-36.2-14.3L320 64 236.6 203c-7.4 12.4-22.3 18.3-36.2 14.3L37.1 170.6c-19.3-5.5-28.8-27.2-19.8-45.1L58.9 42.1zM321.1 128l54.9 91.4c14.9 24.8 44.6 36.6 72.5 28.6L576 211.6l0 167c0 22-15 41.2-36.4 46.6l-204.1 51c-10.2 2.6-20.9 2.6-31 0l-204.1-51C79 419.7 64 400.5 64 378.5l0-167L191.6 248c27.8 8 57.6-3.8 72.5-28.6L318.9 128l2.2 0z"/></svg>
                        </div>
                    </div>
                    {{-- jumlah user --}}
                    <div class="w-full bg-error rounded-lg py-6">
                        <h2 class="text-start text-base text-secondary font-bold mx-2 ">Jumlah Penguna :</h2>
                        <div class="flex justify-between mx-2 ">
                            <p class="text-5xl font-extrabold text-secondary">{{$data['jmlUser']}}</p>
                            <svg xmlns="http://www.w3.org/2000/svg"  width="35px" class="fill-current text-secondary " height="35px" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-213.3 0zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352l117.3 0C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7l-330.7 0c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>
                        </div>
                    </div>
                </div>
            </section>
            {{-- chart --}}
            <section class="grid mx-2 grid-cols-1 md:grid-cols-3 gap-3 lg:mx-0">
                {{-- chart servis --}}
                <div class="w-full  ring-2 ring-primary rounded-lg">
                    <h3 class="text-start text-lg font-bold text-secondary mx-1 my-2">Rangkuman Data Servis</h3>
                    <div>
                         <canvas id="serviceChart" width="600" height="300"></canvas>
                    </div>
                </div>
                <div class=" w-full  ring-2 ring-primary rounded-lg">
                    {{-- chart stok produk --}}
                    <h3 class="text-start text-lg font-bold text-secondary mx-1 my-2">Rangkuman Stok Barang</h3>
                    
                    <div>
                        <canvas id="productPieChart" class="!w-full !h-auto aspect-square"></canvas>
                    </div>
                </div>
                <div class=" w-full  ring-2 ring-primary rounded-lg">
                    {{-- chart stok produk --}}
                    <h3 class="text-start text-lg font-bold text-secondary mx-1 my-2">Rangkuman Data Pesanan</h3>
                    
                    <div>
                         <canvas id="orderChart"></canvas>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
