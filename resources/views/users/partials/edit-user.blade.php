<dialog x-ref="editModal" class="modal">
  <div class="modal-box max-w-2xl">
    <h2 class="font-bold text-lg mb-4">Edit User</h2>

    <form method="POST" :action="'/admin/users/' + selected.id" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- ID Karyawan -->
        <div>
            <x-input-label for="id_karyawan" value="ID Karyawan" />
            <input type="text" id="id_karyawan" name="id_karyawan" class="input input-bordered w-full"
                   x-model="selected.id_karyawan" required />
        </div>

        <!-- Nama -->
        <div>
            <x-input-label for="name" value="Nama" />
            <input type="text" id="name" name="name" class="input input-bordered w-full"
                   x-model="selected.name" required />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <input type="email" id="email" name="email" class="input input-bordered w-full"
                   x-model="selected.email" required />
        </div>

        <!-- Password (optional) -->
        <div>
            <x-input-label for="password" value="Password (biarkan kosong jika tidak diubah)" />
            <input type="password" id="password" name="password" class="input input-bordered w-full" />
        </div>

        <!-- Role -->
        <div>
            <x-input-label for="role" value="Role" />
            <select name="role" id="role" x-model="selected.role" class="select select-bordered w-full" required>
                <option value="" disabled>Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="pimpinan">Pimpinan</option>
                <option value="administrator">Administrator</option>
            </select>
        </div>

        <!-- Tombol Submit -->
        <div>
            <x-primary-button class="w-full">
                Simpan Perubahan
            </x-primary-button>
        </div>
    </form>

    <!-- Tombol Tutup -->
    <form method="dialog" class="modal-backdrop">
        <button 
            class="btn btn-sm mt-4"
            @click="selected = { id: null, id_karyawan: '', name: '', email: '', role: '' }"
        >
            Tutup
        </button>
    </form>
  </div>
</dialog>
