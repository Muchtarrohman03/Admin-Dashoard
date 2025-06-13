<!-- Open the modal using ID.showModal() method -->
<button onclick="edit_modal_{{ $loop->iteration }}.showModal()" class="btn btn-sm text-white btn-warning">
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
<dialog id="edit_modal_{{ $index }}" class="modal">
  <div class="modal-box max-w-2xl max-h-[600px] lg:overflow-y-hidden mx-auto bg-base-100 px-3 py-10 sm:px-6 lg:px-8">
    <h2 class="flex mx-10 text-lg items-center justify-between">Edit Service</h2>
    
    <form enctype="multipart/form-data" method="POST" action="{{ route('admin.services.update', $service->service_id) }}" class="w-full justify-center lg:flex lg:gap-x-6">
      @csrf
      @method('PUT')
      
      <div class="w-full mx-10">
        <!-- Owner -->
        <div class="mt-1 mb-2">
          <x-input-label for="owner" class="text-secondary" :value="__('Owner')" />
          <x-text-input type="text" id="owner" name="owner" class="block mt-1 w-full"  placeholder="{{ $service->owner }}"  :value="old('owner')"  />
          <x-input-error :messages="$errors->get('owner')" class="mt-2" />
        </div>

        <!-- Tanggal Masuk -->
        <div class="mt-1 mb-2">
          <x-input-label for="tanggal_masuk" class="text-secondary" :value="__('Tanggal Masuk')" />
          <x-text-input 
            type="date" 
            id="tanggal_masuk" 
            name="tanggal_masuk" 
            class="block mt-1 w-full" 
            :value="old('tanggal_masuk', $service->tanggal_masuk)" 
          />
          <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-2" />
        </div>
        
        <!-- Kendala -->
        <div class="mt-1 mb-2">
          <x-input-label for="kendala" class="text-secondary" :value="__('Kendala')" />
          <x-textarea 
            id="kendala" 
            name="kendala" 
            class="block mt-1 w-full"
          >{{ old('kendala', $service->kendala) }}</x-textarea>
          <x-input-error :messages="$errors->get('kendala')" class="mt-2" />
        </div>

        <!-- Penggantian Part -->
        <div class="mt-1 mb-2">
          <x-input-label for="penggantian_part" class="text-secondary" :value="__('Penggantian Part')" />
          <x-text-input type="text" id="penggantian_part" name="penggantian_part" class="block mt-1 w-full" placeholder="{{ $service->penggantian_part }}"  :value="old('penggantian_part')"  />
          <x-input-error :messages="$errors->get('penggantian_part')" class="mt-2" />
        </div>

        <!-- Tipe -->
        <div class="mt-1 mb-2">
          <x-input-label for="tipe" class="text-secondary" :value="__('Tipe')" />
          <x-text-input type="text" id="tipe" name="tipe" class="block mt-1 w-full" placeholder="{{ $service->tipe }}"  :value="old('tipe')" />
          <x-input-error :messages="$errors->get('tipe')" class="mt-2" />
        </div>

        <!-- Serial Number -->
        <div class="mt-1 mb-2">
          <x-input-label for="serial_number" class="text-secondary" :value="__('Serial Number')" />
          <x-text-input type="text" id="serial_number" name="serial_number" class="block mt-1 w-full" placeholder="{{ $service->serial_number }}"  :value="old('serial_number')" />
          <x-input-error :messages="$errors->get('serial_number')" class="mt-2" />
        </div>

        <!-- Submit -->
        <x-primary-button class="btn w-full justify-center mt-2">
          {{ __('Submit') }}
        </x-primary-button>
      </div>
    </form>
  </div>

  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>
