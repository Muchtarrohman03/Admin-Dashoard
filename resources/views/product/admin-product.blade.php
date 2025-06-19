@section('title', 'Kelola Produk')
<x-app-layout>
        <div class=" mt-10 max-w-7xl mx-auto px-3 py-10 sm:px-6 lg:px-8">
            @if (session()->has('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show" x-transition>
                    <x-alert message="{{ session('success') }}" />
                </div>
            @endif
          

            <div class=" flex mt-6 items-center justify-between">
                <h2 class="font-semibold font-xl text-secondary">List Product</h2>
                @include('product.partials.add-product')
             
            </div>
            <div class=" grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 mt-4 gap-4">
                @foreach ($products as $product)
                    <div class="mx-3">
                        <x-image-hover-button 
                            :image="$product->image" 
                            :alt="$product->title" 
                            buttonText="Preview" 
                            :buttonLink="route('product.preview', $product->slug)" 
                        />
                        <div class="flex justify-between">
                            <p class="font-base text-secondary text-xl ">{{$product->title}}</p>
                            <p class="font-base text-secondary text-xl">stok : {{$product->stock}}</p>
                        </div>
                        <p class="font-semibold text-gray-400 mb-1">Rp.{{ number_format($product->harga) }}</p>
                        <div class="flex justify-between gap-2 mx-2">
                        <button
                        type="button"
                        onclick="document.getElementById('edit_product_modal_{{ $product->id }}').showModal()"
                         class="btn w-5/6 btn-primary">
                                                <svg 
                        class="fill-current"
                        xmlns="http://www.w3.org/2000/svg" 
                        viewBox="0 0 512 512" 
                        width="25" 
                        height="25"
                        >
                        <!-- Isi path tetap sama -->
                        <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/>
                        </svg>
                        </button>
                        @include('product.partials.edit-product', ['product' => $product])
                        @include('product.partials.delete-product')
                        </div>
                    
                    </div>
                @endforeach
            </div>

            <div class="mt-4 ">
                {{$products->links()}}
            </div>
        </div>
</x-app-layout>