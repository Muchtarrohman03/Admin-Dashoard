<!-- Tombol untuk membuka modal -->
<button class="btn btn-sm btn-primary" onclick="my_modal_7.showModal()">Tambah</button>

<!-- Modal -->
<dialog id="my_modal_7" class="modal">
  <div class="modal-box max-w-2xl max-h-[600px] lg:overflow-y-hidden mx-auto bg-base-100 px-3 py-10 sm:px-6 lg:px-8">
    <h2 class="flex mx-10 text-lg items-center justify-between text-primary">Tambah User</h2>

    <form enctype="multipart/form-data" method="POST" action="{{ route('admin.users.store') }}" class="w-full justify-center lg:flex lg:gap-x-6">
      @csrf
      <div class="w-full mx-10 space-y-4">
        
        <!-- ID Karyawan -->
        <div>
          <x-input-label for="id_karyawan" :value="__('ID Karyawan')" />
          <x-text-input id="id_karyawan" class="block mt-1 w-full" type="text" name="id_karyawan" required autofocus />
        </div>

        <!-- Nama -->
        <div>
          <x-input-label for="name" :value="__('Nama')" />
          <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required />
        </div>

        <!-- Email -->
        <div>
          <x-input-label for="email" :value="__('Email')" />
          <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required />
        </div>

        <!-- Password -->
        <div>
          <x-input-label for="password" :value="__('Password')" />
          <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
        </div>

        <!-- Role -->
        <div>
          <x-input-label for="role" :value="__('Role')" />
          <select name="role" id="role" class="select select-bordered w-full" required>
            <option disabled selected>Pilih Role</option>
            <option value="admin">Admin</option>
            <option value="pimpinan">Pimpinan</option>
            <option value="administrator">Administrator</option>
          </select>
        </div>

        <x-primary-button class="btn w-full justify-center mt-2">
          {{ __('Submit') }}
        </x-primary-button>
      </div>
    </form>
  </div>

  <!-- backdrop modal -->
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>
