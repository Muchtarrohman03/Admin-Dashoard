@section('title', 'User')
<x-app-layout>
    <div class="mt-10 max-w-7xl mx-auto px-3 py-10 sm:px-6 lg:px-8">
        <div class="flex mt-6 items-center justify-between">
            <h1 class="text-start my-3 text-base font-bold text-secondary">Add User</h1>
        </div>
    
    <table class="table w-full table-zebra border border-base-300">
        <thead>
            <tr class="text-secondary font-bold">
                <th>No.</th>
                <th>ID Karyawan</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th> <!-- ✅ Tambahkan kolom role -->
                <th>Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="text-primary">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->id_karyawan }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <!-- ✅ Tampilkan role -->
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

</x-app-layout>