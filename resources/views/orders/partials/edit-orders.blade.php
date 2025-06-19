<!-- Open the modal using ID.showModal() method -->
<button onclick="order_modal_{{ $loop->iteration }}.showModal()" class="btn btn-sm text-white btn-warning">
  <svg 
   class="fill-current"
  xmlns="http://www.w3.org/2000/svg" 
  viewBox="0 0 512 512" 
  width="15" 
  height="15"
>
  <!-- Isi path tetap sama -->
  <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/>
</svg>
</button>
<dialog id="order_modal_{{ $index }}" class="modal">
  <div class="modal-box max-w-2xl max-h-[600px] lg:overflow-y-auto mx-auto bg-base-100 px-3 py-10 sm:px-6 lg:px-8">
           <h2 class="text-lg font-semibold mb-4">Edit Order</h2>

        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.orders.update', $order->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Invoice (biasanya tidak diubah) --}}
            <div class="mb-3">
                <x-input-label for="invoice" :value="__('Invoice')" class="text-secondary" />
                <x-text-input id="invoice" name="invoice" type="text" class="block w-full"
                              :value="old('invoice', $order->invoice)" readonly />
            </div>

            {{-- Tanggal Pembelian --}}
            <div class="mb-3">
                <x-input-label for="tanggal_pembelian" :value="__('Tanggal Pembelian')" class="text-secondary" />
                <x-text-input id="tanggal_pembelian" name="tanggal_pembelian" type="date" class="block w-full"
                              :value="old('tanggal_pembelian', $order->tanggal_pembelian->format('Y-m-d'))" />
                <x-input-error :messages="$errors->get('tanggal_pembelian')" class="mt-2" />
            </div>

            {{-- Pembeli --}}
            <div class="mb-3">
                <x-input-label for="pembeli" :value="__('Pembeli')" class="text-secondary" />
                <x-text-input id="pembeli" name="pembeli" type="text" class="block w-full"
                              :value="old('pembeli', $order->pembeli)" />
                <x-input-error :messages="$errors->get('pembeli')" class="mt-2" />
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <x-input-label for="email" :value="__('Email')" class="text-secondary" />
                <x-text-input id="email" name="email" type="email" class="block w-full"
                              :value="old('email', $order->email)" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Telepon --}}
            <div class="mb-3">
                <x-input-label for="telepon" :value="__('Telepon')" class="text-secondary" />
                <x-text-input id="telepon" name="telepon" type="text" class="block w-full"
                              :value="old('telepon', $order->telepon)" />
                <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
            </div>

            {{-- Alamat Pengiriman --}}
            <div class="mb-5">
                <x-input-label for="alamat_pengiriman" :value="__('Alamat Pengiriman')" class="text-secondary" />
                <x-textarea id="alamat_pengiriman" name="alamat_pengiriman" class="block w-full"
                >{{ old('alamat_pengiriman', $order->alamat_pengiriman) }}</x-textarea>
                <x-input-error :messages="$errors->get('alamat_pengiriman')" class="mt-2" />
            </div>

            {{-- Produk & Kuantitas --}}
           <div class="mb-6">
                <p class="font-semibold mb-2">Produk</p>
                @foreach($products as $product)
                    @php
                        $pivot = $order->products->firstWhere('id', $product->id)?->pivot;
                    @endphp

                    <div x-data="{
                            selected: {{ $pivot ? 'true' : 'false' }},
                            qty: '{{ old("products.$product->id.kuantitas", $pivot?->kuantitas) }}'
                        }" 
                        class="flex items-center space-x-4 mb-2">

                        <!-- Checkbox Produk -->
                        <input type="checkbox"
                            class="checkbox checkbox-primary"
                            name="products[{{ $product->id }}][selected]"
                            value="1"
                            x-model="selected">

                        <!-- Nama Produk -->
                        <span class="w-48">{{ $product->title }}</span>

                        <!-- Input Kuantitas -->
                        <input type="number"
                            class="input input-bordered w-24"
                            name="products[{{ $product->id }}][kuantitas]"
                            min="1"
                            x-bind:disabled="!selected"
                            x-model="qty"
                            x-bind:value="qty"
                            data-product-id="{{ $product->id }}">
                    </div>
                @endforeach
                <x-input-error :messages="$errors->get('products')" class="mt-2" />
            </div>


            {{-- Tombol Submit --}}
            <x-primary-button class="btn w-full">{{ __('Update Order') }}</x-primary-button>
        </form>
    </div>

  </div>

  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>

\