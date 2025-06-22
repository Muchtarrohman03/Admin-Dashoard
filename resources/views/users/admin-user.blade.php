@section('title', 'Kelola User')
<x-app-layout >
    <div class="mt-10 max-w-7xl mx-auto px-3 py-10 sm:px-6 lg:px-8">
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show" x-transition>
            <x-alert message="{{ session('success') }}" />
            </div>
        @endif
        @if (session()->has('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition>
                <x-alert-error message="{{ session('error') }}" />
            </div>
        @endif
        <div class="flex mt-6 items-center justify-between">
            <h1 class="text-start my-3 text-base font-bold text-secondary">Tabel Data User</h1>
            <div class="flex justify-between items-center gap-2" x-data>
                @include('users.partials.add-user')
            </div>
        </div>   

        <!-- Tabel User -->
        <div class="overflow-x-auto">
            <table class="table w-full table-zebra border border-base-300 mt-6">
                <thead class="text-base text-secondary font-semibold">
                    <tr>
                        <th>No.</th>
                        <th>ID Karyawan</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="text-primary">
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
                            <td class="w-full flex gap-2">
                                <div>
                                    @include('users.partials.edit-user', ['user' => $user, 'index' => $loop->iteration])
                                    @include('users.partials.delete-user',['user' => $user, 'index' => $loop->iteration])
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
