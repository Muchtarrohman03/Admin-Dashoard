<x-app-layout x-data="userModal()">
    <div class="mt-10 max-w-7xl mx-auto px-3 py-10 sm:px-6 lg:px-8">
        <div class="flex mt-6 items-center justify-between">
            <h1 class="text-start my-3 text-base font-bold text-secondary">Add User</h1>
            <div class="flex justify-between items-center gap-2" x-data>
                @include('users.partials.add-user')

                <!-- Tombol Edit -->
                <button 
                    class="btn btn-warning btn-sm text-white"
                    x-show="selected.id"
                    x-cloak
                    @click="openEdit()"
                >
                    Edit
                </button>

                @include('users.partials.edit-user')
            </div>
        </div>

        <!-- Tabel User -->
        <table class="table w-full table-zebra border border-base-300 mt-6">
            <thead>
                <tr class="text-secondary font-bold">
                    <th><input type="checkbox" id="select-all" class="checkbox" /></th>
                    <th>No.</th>
                    <th>ID Karyawan</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="text-primary">
                        <td>
                            <input type="checkbox" class="user-checkbox checkbox"
                                   @change="selectUser({{ $user->id }}, '{{ $user->id_karyawan }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->getRoleNames()->first() }}')">
                        </td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->id_karyawan }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->getRoleNames() as $role)
                                <span class="badge badge-outline badge-primary text-xs">{{ $role }}</span>
                            @endforeach
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Script Alpine -->
    <script>
        function userModal() {
            return {
                selected: {
                    id: null,
                    id_karyawan: '',
                    name: '',
                    email: '',
                    role: ''
                },
                selectUser(id, id_karyawan, name, email, role) {
                    this.selected.id = id;
                    this.selected.id_karyawan = id_karyawan;
                    this.selected.name = name;
                    this.selected.email = email;
                    this.selected.role = role;
                    console.log("Selected user:", this.selected);
                },
                openEdit() {
                    if (this.selected.id) {
                        this.$refs.editModal.showModal();
                    }
                }
            }
        }
    </script>
</x-app-layout>
