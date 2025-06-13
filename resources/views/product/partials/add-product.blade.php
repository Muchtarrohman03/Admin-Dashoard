<button onclick="my_modal_2.showModal()" class="btn btn-sm btn-success text-white">
<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 448 512"><path fill="currentColor" d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zM200 
    344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
     tambah
</button>
<dialog id="my_modal_2" class="modal">
    <div class=" modal-box max-w-2xl max-h-[600px] lg:overflow-y-auto mx-auto  bg-base-100 px-3 py-10 sm:px-6 lg:px-8">
            <div class=" flex mt-6 items-center justify-between">
                <h2 class="font-semibold text-secondary font-xl">Add Product</h2>
            </div>
            <div class="mt-3" x-data="{imageUrl: '/storage/noimage.png' }">
                <form enctype="multipart/form-data" method="POST" action="{{route('admin.product.store')}}" >
                    @csrf
                    <div class="w-full justify-center lg:flex lg:gap-x-6">
                        <div class="w-full lg:w-1/2">
                        <img :src="imageUrl" class="rounded-md" alt="">
                        </div>
                        <div class="w-full lg:w-1/2">
                            <div class="mt-0">
                                <x-input-label for="image"  class="text-secondary" :value="__('Pilih Gambar')" />
                                <x-text-input 
                                accept="image/*"
                                id="image" 
                                class="block mt-1 w-full border p-2" 
                                type="file" 
                                name="image" 
                                :value="old('image')" required
                                @change="imageUrl = URL.createObjectURL($event.target.files[0])"
                                
                            />
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />  
                            </div>
                            <div class="mt-1">
                                <x-input-label for="images" class="text-secondary" :value="__('Gambar Tambahan')" />
                                <input id="images" name="images[]" type="file" class="block w-full" multiple accept="image/*">

                            </div>
                            <div class="mt-1">
                                <x-input-label for="title" class="text-secondary" :value="__('Nama Produk')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />  
                            </div>
                            <div class="mt-1">
                                <x-input-label for="harga"  class="text-secondary" :value="__('Harga')" />
                                <x-text-input id="harga" class="block mt-1 w-full" type="text" name="harga" :value="old('harga')" required />
                                <x-input-error :messages="$errors->get('harga')" class="mt-2" />  
                            </div>
                            <div class="mt-1">
                                <x-input-label for="stock" class="text-secondary" :value="__('Stok')" />
                                <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock', )" min="0" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>
                            <div class="mt-1">
                                <x-input-label for="description"  class="text-secondary" :value="__('Deskripsi')" />
                                <x-textarea id="description" class="block mt-1 w-full" type="text" name="description">
                                    {{old('description')}}
                                </x-textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />     
                            </div>
                        </div>
                    </div>
                    <div class="w-full ">
                          <div x-data="specForm()" class="mt-4">
                                <h2 class="text-lg font-semibold mb-2 text-secondary">Spesifikasi Produk</h2>

                                <template x-for="(spec, index) in specifications" :key="index">
                                    <div class="flex items-center gap-2 mb-2">
                                        <!-- @php-ignore -->
                                        <input 
                                            type="text" 
                                            :name="'specification[' + index + '][key]'" 
                                            x-model="spec.key" 
                                            placeholder="Nama Spesifikasi"
                                            class="w-1/2 p-2 border rounded"
                                        />

                                        <!-- @php-ignore -->
                                        <input 
                                            type="text" 
                                            :name="'specification[' + index + '][value]'" 
                                            x-model="spec.value" 
                                            placeholder="Isi Spesifikasi"
                                            class="w-1/2 p-2 border rounded"
                                        />

                                        <!-- Tombol Hapus -->
                                        <button 
                                            type="button" 
                                            @click="removeSpecification(index)" 
                                            class="text-red-500 text-sm"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </template>


                                <button type="button" @click="addSpecification"
                                    class="text-sm bg-blue-500 text-white px-3 py-1 rounded">Tambah Spesifikasi</button>
                            </div>
                            <x-primary-button class=" btn w-full justfy-center mt-2  ">
                            {{ __('Submit') }}
                            </x-primary-button>
                    </div>
                </form>
            </div>
    </div>
    <form method="dialog" class="modal-backdrop">
    <button>close</button>
    </form>
    <script>
    function specForm() {
        return {
            specifications: [
                { key: '', value: '' }
            ],
            addSpecification() {
                this.specifications.push({ key: '', value: '' });
            },
            removeSpecification(index) {
                this.specifications.splice(index, 1);
            }
        }
    }
</script>


 </dialog>