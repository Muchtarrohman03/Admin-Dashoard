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
                        Edit
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