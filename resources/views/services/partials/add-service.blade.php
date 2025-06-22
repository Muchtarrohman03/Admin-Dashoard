<!-- Open the modal using ID.showModal() method -->
<button class="btn btn-sm btn-primary" onclick="my_modal_3.showModal()">Tambah</button>
<dialog id="my_modal_3" class="modal ">
  <div class=" modal-box max-w-2xl max-h-[600px] lg:overflow-y-hidden mx-auto  bg-base-100 px-3 py-10 sm:px-6 lg:px-8">
    <h2 class="flex mx-10 text-lg items-center justify-between text-secondary font-semibold">Tambah Servis</h2>
    <form enctype="multipart/form-data" method="POST" action="{{route('admin.services.store')}}" class="w-full justify-center lg:flex lg:gap-x-6">
        @csrf
        <div class="w-full mx-10">
            {{-- input owner --}}
            <div class="mt-1 mb-2">
                <x-input-label for="owner" class="text-secondary" :value="__('Owner')" />
                <x-text-input id="owner" class="block mt-1 w-full" type="text" name="owner" :value="old('owner')" required />
                <x-input-error :messages="$errors->get('owner')" class="mt-2" />  
            </div>
            {{-- input tanggal masuk --}}
            <div class="mt-1 mb-2">
                <x-input-label for="tanggal_masuk" class="text-secondary" :value="__('Tanggal Masuk')" />
                <x-text-input id="tanggal_masuk" class="block mt-1 w-full" type="date" name="tanggal_masuk" :value="old('tanggal_masuk')" required />
                <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-2" />  
            </div>
            {{-- input kendala --}}
            <div class="mt-1 mb-2">
                <x-input-label for="kendala" class="text-secondary" :value="__('Kendala')" />
                <x-textarea id="kendala" class="block mt-1 w-full" type="text" name="kendala">
                {{old('kendala')}}
                </x-textarea>
                <x-input-error :messages="$errors->get('kendala')" class="mt-2" />  
            </div>
            {{-- input penggantian part --}}
            <div class="mt-1 mb-2">
                <x-input-label for="penggantian_part" class="text-secondary" :value="__('Penggantian Part')" />
                <x-text-input id="penggantian_part" class="block mt-1 w-full" type="text" name="penggantian_part" :value="old('penggantian_part')" required />
                <x-input-error :messages="$errors->get('penggantian_part')" class="mt-2" />  
            </div>
            {{-- input tipe --}}
            <div class="mt-1 mb-2">
                <x-input-label for="tipe" class="text-secondary" :value="__('Tipe')" />
                <x-text-input id="tipe" class="block mt-1 w-full" type="text" name="tipe" :value="old('tipe')" required />
                <x-input-error :messages="$errors->get('tipe')" class="mt-2" />  
            </div>
            {{-- input serial number --}}
            <div class="mt-1 mb-2">
                <x-input-label for="serial_number" class="text-secondary" :value="__('Serial Number')" />
                <x-text-input id="serial_number" class="block mt-1 w-full" type="text" name="serial_number" :value="old('serial_number')" required />
                <x-input-error :messages="$errors->get('serial_number')" class="mt-2" />  
            </div>
            <x-primary-button class=" btn w-full justfy-center mt-2  ">
            {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>