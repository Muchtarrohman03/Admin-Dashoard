<!-- Tombol buka modal -->
<button class="btn btn-sm btn-primary" onclick="my_modal_order.showModal()">Tambah Pesanan</button>

<dialog id="my_modal_order" class="modal">
  <div class="modal-box max-w-2xl max-h-[600px] lg:overflow-y-auto mx-auto bg-base-100 px-3 py-10 sm:px-6 lg:px-8">
    <h2 class="text-lg font-bold text-primary mb-4">Tambah Pesanan</h2>

    <form enctype="multipart/form-data" method="POST" action="{{ route('admin.orders.store') }}" class="w-full space-y-4">
      @csrf

      {{-- Select Produk --}}
      <div>
        @foreach($products as $product)
        <div class="flex items-center space-x-4 mb-2">
            <input type="checkbox" 
                  name="products[{{ $product->id }}][selected]" 
                  value="1" 
                  class="checkbox checkbox-primary product-checkbox"
                  onchange="toggleQty(this, {{ $product->id }})" />

            <input type="number" 
                  name="products[{{ $product->id }}][kuantitas]" 
                  placeholder="Qty" 
                  class="input input-bordered w-24 qty-input" 
                  min="1" 
                  disabled
                  data-product-id="{{ $product->id }}" />

      <script>
      function toggleQty(checkbox, productId) {
          const qtyInput = document.querySelector(`.qty-input[data-product-id="${productId}"]`);
          qtyInput.disabled = !checkbox.checked;
          if (!checkbox.checked) qtyInput.value = '';
      }
      </script>
        </div>
        @endforeach
      </div>

      {{-- Tanggal Pembelian --}}
      <div>
        <x-input-label for="tanggal_pembelian" class="text-secondary" :value="__('Tanggal Pembelian')" />
        <x-text-input id="tanggal_pembelian" class="block mt-1 w-full" type="date" name="tanggal_pembelian" :value="old('tanggal_pembelian')" required />
        <x-input-error :messages="$errors->get('tanggal_pembelian')" class="mt-2" />
      </div>

      {{-- Pembeli --}}
      <div>
        <x-input-label for="pembeli" class="text-secondary" :value="__('Nama Pembeli')" />
        <x-text-input id="pembeli" class="block mt-1 w-full" type="text" name="pembeli" :value="old('pembeli')" required />
        <x-input-error :messages="$errors->get('pembeli')" class="mt-2" />
      </div>

      {{-- Email --}}
      <div>
        <x-input-label for="email" class="text-secondary" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      {{-- Telepon --}}
      <div>
        <x-input-label for="telepon" class="text-secondary" :value="__('Telepon')" />
        <x-text-input id="telepon" class="block mt-1 w-full" type="text" name="telepon" :value="old('telepon')" required />
        <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
      </div>

      {{-- Alamat Pengiriman --}}
      <div>
        <x-input-label for="alamat_pengiriman" class="text-secondary" :value="__('Alamat Pengiriman')" />
        <x-textarea id="alamat_pengiriman" name="alamat_pengiriman" class="block mt-1 w-full" required>{{ old('alamat_pengiriman') }}</x-textarea>
        <x-input-error :messages="$errors->get('alamat_pengiriman')" class="mt-2" />
      </div>

      {{-- Tombol Submit --}}
      <x-primary-button class="btn w-full mt-2">
        {{ __('Simpan Pesanan') }}
      </x-primary-button>
    </form>
  </div>

  {{-- Backdrop (klik luar untuk tutup modal) --}}
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>
