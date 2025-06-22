<!-- Open the modal using ID.showModal() method -->
<button onclick="edit_modal_{{ $loop->iteration }}.showModal()" class="btn btn-sm text-white btn-warning inline-flex items-center">
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
    <h2 class="flex mx-10 text-lg items-center justify-between text-primary">Edit User</h2>

    <form method="POST" enctype="multipart/form-data" action="{{route('admin.users.update',$user->id)}}" class="w-full justify-center lg:flex lg:gap-x-6">
        @csrf
        @method('PUT')
        <div class="w-full mx-10 space-y-4">
            <!-- ID Karyawan -->
            <div>
                <x-input-label for="id_karyawan" value="ID Karyawan" />
                <input type="text" id="id_karyawan" name="id_karyawan" placeholder="{{$user->id_karyawan}}" :value="old('id_karyawan')" class="input input-bordered w-full"
            />
            </div>

            <!-- Nama -->
            <div>
                <x-input-label for="name" value="Nama" />
                <input type="text" id="name" name="name" class="input input-bordered w-full" placeholder="{{$user->name}}" :value="old('name')"
               />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" value="Email" />
                <input type="email" id="email" name="email" class="input input-bordered w-full" placeholder="{{$user->email}}" :value="old('email')"
                     />
            </div>

            <!-- Password (optional) -->
            <div>
                <x-input-label for="password" value="Password" />
                <input type="password" id="password" name="password" class="input input-bordered w-full" />
            </div>

            <!-- Role -->
            <div>
                <x-input-label for="role" value="Role" />
                <select name="role" id="role" class="select select-bordered w-full" required>
                    <option value="" disabled>Pilih Role</option>
                    <option value="admin">admin</option>
                    <option value="pimpinan">pimpinan</option>
                    <option value="super admin">super admin</option>
                </select>
            </div>

            <!-- Tombol Submit -->
            <div>
            <x-primary-button class="btn w-full justify-center mt-2">
              {{ __('Submit') }}
            </x-primary-button>
            </div>
        </div>
    </form>
 </div>

  <!-- backdrop modal -->
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
  </div>
</dialog>
