<x-preview-layout>
    <section class="max-w-7xl mx-auto px-3 py-0 sm:px-6 lg:px-8">
        <div class="hero min-h-screen" style="background-image: url('{{ asset('storage/' . $product->image) }}')">
            <div class="hero-overlay bg-opacity-70"></div>
            <div class="hero-content text-center text-neutral-content">
                <div class="max-w-md">
                <h1 class="mb-5 text-primary text-5xl font-bold">{{$product->title}}</h1>
                <p class="mb-5 text-secondary font-bold">{{$product->description}}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="mt-10 max-w-7xl mx-auto px-3 py-0 sm:px-6 lg:px-8">
        <h2 class="text-2xl border-l-4 border-primary pl-4 font-bold mb-4 text-secondary">Gambar Produk</h2>

            <div class="relative max-w-6xl mx-auto">
                
                <!-- Tombol Navigasi Kiri -->
                <div class="absolute -left-8 top-1/2 scale-50 -translate-y-1/2 z-10 hidden sm:block">
                <div class="swiper-button-prev text-primary scale-150"></div>
                </div>

                <!-- Carousel -->
                <div class="swiper mySwiper py-12">
                <div class="swiper-wrapper">
                    @foreach ($product->images as $carousel)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $carousel->image) }}"
                            class="w-full h-56 sm:h-80 object-cover rounded-md"
                            alt="Product Image" />
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="swiper-pagination mt-4"></div>
                </div>

                <!-- Tombol Navigasi Kanan -->
                <div class="absolute -right-8 top-1/2 scale-50 -translate-y-1/2 z-10 hidden sm:block">
                <div class="swiper-button-next text-primary scale-150"></div>
                </div>

            </div>
    </section>


    <section class="mt-10 max-w-7xl mx-auto px-3 py-0 sm:px-6 lg:px-8">
        <h2 class="text-2xl border-l-4 border-primary pl-4 font-bold mb-4 text-secondary">Spesifikasi Produk</h2>

        <div class="overflow-x-auto">
            <table class="table w-full table-zebra border border-base-300 rounded-lg">
                <tbody>
                    @foreach ($product->specification->data ?? [] as $spec)
                        <tr>
                            <td class="px-4 py-2">{{ $spec['key'] }}</td>
                            <td>:</td>
                            <td class="px-4 py-2">{{ $spec['value'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>    
</x-preview-layout>