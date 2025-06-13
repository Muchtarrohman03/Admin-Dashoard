<dialog id="edit_product_modal_{{ $product->id }}" class="modal">
  <div class="modal-box max-w-2xl max-h-[90vh] lg:overflow-y-auto mx-auto bg-base-100 px-3 py-10 sm:px-6 lg:px-8">
    <h2 class="font-semibold text-secondary text-xl mb-4">Edit Produk</h2>

    <form enctype="multipart/form-data" method="POST" action="{{ route('admin.product.update', $product->id) }}">
      @csrf
      @method('PUT')

      <div class="w-full justify-center lg:flex lg:gap-x-6">
        <div class="w-full lg:w-1/2">
          <img src="{{ asset('storage/' . ($product->image ?? 'noimage.png')) }}" class="rounded-md w-full h-auto" alt="Preview">
                  <div class="grid grid-cols-3 gap-2 mt-2">
          @foreach($product->images as $img)
            <div class="relative border rounded overflow-hidden">
              <img src="{{ asset('storage/' . $img->image) }}" class="w-full h-24 object-cover" alt="">
              <button
                type="button"
                class="absolute top-1 right-1 bg-slate-500/60 text-white rounded-full w-5 h-5 text-xs"
                @click.prevent="
                  fetch('{{ route('product.carousel.delete', $img->id) }}', {
                    method: 'DELETE',
                    headers: {
                      'X-CSRF-TOKEN': '{{ csrf_token() }}',
                      'X-Requested-With': 'XMLHttpRequest'
                    }
                  }).then(() => $el.closest('div').remove());
                "
              >
                &times;
              </button>
            </div>
          @endforeach
        </div>
        </div>

        <div class="w-full lg:w-1/2 space-y-2">
          <x-input-label for="image" class="text-secondary" :value="__('Pilih Gambar')" />
          <x-text-input
            accept="image/*"
            id="image"
            class="block mt-1 w-full border p-2"
            type="file"
            name="image"
          />

          <x-input-label for="title" class="text-secondary" :value="__('Nama Produk')" />
          <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $product->title }}" />

          <x-input-label for="harga" class="text-secondary" :value="__('Harga')" />
          <x-text-input id="harga" class="block mt-1 w-full" type="text" name="harga" value="{{ $product->harga }}" />

          <x-input-label for="stock" class="text-secondary" :value="__('Stok')" />
          <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" value="{{ $product->stock }}" min="0" />

          <x-input-label for="description" class="text-secondary" :value="__('Deskripsi')" />
          <x-textarea id="description" class="block mt-1 w-full" name="description">{{ $product->description }}</x-textarea>
        </div>
      </div>

      <div class="mt-4">
        <x-input-label for="images" class="text-secondary" :value="__('Gambar Tambahan')" />
        <input id="images" name="images[]" type="file" class="block w-full" multiple accept="image/*">


      </div>

      <div x-data="specForm({{ json_encode($product->specification ? [$product->specification->toArray()] : []) }})" class="mt-6">
        <h2 class="text-lg font-semibold text-secondary mb-2">Spesifikasi Produk</h2>

        <template x-for="(spec, index) in specifications" :key="index">
          <div class="flex items-center gap-2 mb-2">
            <input type="text" :name="'specification[' + index + '][key]'" x-model="spec.key" placeholder="Nama Spesifikasi" class="w-1/2 p-2 border rounded">
            <input type="text" :name="'specification[' + index + '][value]'" x-model="spec.value" placeholder="Isi Spesifikasi" class="w-1/2 p-2 border rounded">
            <button type="button" @click="removeSpecification(index)" class="text-red-500 text-sm">Hapus</button>
          </div>
        </template>

        <button type="button" @click="addSpecification" class="text-sm bg-blue-500 text-white px-3 py-1 rounded">Tambah Spesifikasi</button>
      </div>

      <x-primary-button class="btn w-full justify-center mt-4">
        {{ __('Simpan Perubahan') }}
      </x-primary-button>
    </form>
  </div>

  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>

<script>
function specForm(initial = []) {
  return {
    specifications: initial.length > 0 ? initial : [{ key: '', value: '' }],
    addSpecification() {
      this.specifications.push({ key: '', value: '' });
    },
    removeSpecification(index) {
      this.specifications.splice(index, 1);
    }
  }
}
</script>
