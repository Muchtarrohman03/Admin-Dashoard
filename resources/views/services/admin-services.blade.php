@section('title', 'Kelola Data Servis')
<x-app-layout>
        <div class=" mt-10 max-w-7xl mx-auto px-3 py-10 sm:px-6 lg:px-8">
            @if (session()->has('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show" x-transition>
                    <x-alert message="{{ session('success') }}" />
                </div>
            @endif
            <div class=" flex mt-6 items-center justify-between">
                <h2 class="font-semibold font-xl text-secondary">Tabel Data Servis</h2>
                 @include('services.partials.add-service')
            </div>
            {{-- Search, filter bar, download button --}}
            <div class="block lg:flex my-5 items-center justify-between">
                <form method="GET" action="{{ route('admin.services') }}" x-data @submit.prevent="if ($refs.searchInput.value.trim() !== '') $el.submit()">
                    <div class="join">
                        {{-- search input --}}
                        <div>
                            <div>
                                <input type="search" x-ref="searchInput" name="search" class="input input-sm input-bordered join-item" placeholder="Cari Owner" value="{{ request('search') }}"/>
                            </div>
                        </div>
                        {{-- filter select --}}
                       <select name="filter" id="filterSelect" class="select select-sm select-bordered join-item leading-tight text-xs"
                        @change="window.location.href = $event.target.value === '' ? '{{ route('admin.services') }}' : '{{ route('admin.services') }}?filter=' + $event.target.value" >
                            <option value="">Semua</option>
                            <option value="day" {{ request('filter') == 'day' ? 'selected' : '' }}>Hari ini</option>
                            <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>Minggu ini</option>
                            <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Bulan ini</option>
                        </select>
                        <div class="indicator">
                            {{-- search button --}}
                            <button type="submit" class="btn btn-sm btn-primary join-item">
                                <svg class="fill-current w-5 h-5  " xmlns="http://www.w3.org/2000/svg"
                                        x="0px" y="0px" viewBox="0 0 50 50">
                                        <path
                                            d="M 21 3 C 11.601563 3 4 10.601563 4 20 C 4 29.398438 11.601563 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601563 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z">
                                        </path>
                                    </svg>
                            </button>
                            
                        </div>
                    </div>
                </form>
                {{-- Export to excel button --}}
                <div class="mt-1 lg:mt-0">
                    <a href="{{ route('services.export', request()->only(['search', 'filter'])) }}">
                        <button class="btn btn-sm btn-success text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="w-4 h-4 fill-white">
                            <path d="M64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-288-128 0c-17.7 0-32-14.3-32-32L224 0 64 0zM256 0l0 128 128 0L256 0zM155.7 250.2L192 302.1l36.3-51.9c7.6-10.9 22.6-13.5 33.4-5.9s13.5 22.6 5.9 33.4L221.3 344l46.4 66.2c7.6 10.9 5 25.8-5.9 33.4s-25.8 5-33.4-5.9L192 385.8l-36.3 51.9c-7.6 10.9-22.6 13.5-33.4 5.9s-13.5-22.6-5.9-33.4L162.7 344l-46.4-66.2c-7.6-10.9-5-25.8 5.9-33.4s25.8-5 33.4 5.9z"/>
                        </svg>
                        Download
                        </button>
                    </a>
                </div>

            </div>
            <div class="overflow-x-auto">
                @if($services->count() > 0)
                <table class="table text-primary">
                <!-- head -->
                <thead class=" text-base text-secondary font-semibold">
                <tr>
                    <th>No.</th>
                    <th>Service ID</th>
                    <th>Owner</th>
                    <th>Tanggal Masuk</th>
                    <th>Kendala</th>
                    <th>Penggantian Part</th>
                    <th>Tipe</th>
                    <th>Serial Number</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($services as $service )
                <!-- row 1 -->
                <tr>
                    <th>{{ $services->firstItem() + $loop->index }}</th>
                    <td>{{$service->service_id}}</td>
                    <td>{{$service->owner}}</td>
                    <td>{{ $service->tanggal_masuk_formatted }}</td>
                    <td>{{$service->kendala}}</td>
                    <td>{{$service->penggantian_part}}</td>
                    <td>{{$service->tipe}}</td>
                    <td>{{$service->serial_number}}</td>
                    <td>
                        <div class="flex justify-between gap-2">
                            @include('services.partials.edit-service', ['service' => $service, 'index' => $loop->iteration])
                            @include('services.partials.delete-service',['service' => $service, 'index' => $loop->iteration])
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
                </table>
                    <div class="mt-4 ">
                       {{ $services->links() }}
                        <script>
                            // Ambil semua link yang mengarah ke ?page=1
                            document.querySelectorAll('a[href*="page=1"]').forEach(link => {
                                const url = new URL(link.href);

                                // Hapus parameter page jika = 1
                                if (url.searchParams.get('page') === '1') {
                                    url.searchParams.delete('page');

                                    // Bangun kembali URL tanpa page=1
                                    const cleanUrl = url.pathname + (url.searchParams.toString() ? '?' + url.searchParams.toString() : '');
                                    link.href = cleanUrl;
                                }
                            });
                        </script>
                    </div>
                    @if(request()->has('search'))
                        <div class="text-center mt-4">
                            <a href="{{ route('admin.services') }}" class="btn btn-ghost btn-sm  mt-1">Kembali</a>
                        </div>
                    @endif

                @else
                    @if(request()->filled('search'))
                        <div class="text-center text-gray-500 mt-5">
                            <p>Data tidak ditemukan untuk: <strong>{{ request('search') }}</strong>.</p>
                            <a href="{{ route('admin.services') }}" class="btn btn-ghost btn-sm  mt-1">Kembali</a>
                        </div>
                    @else
                        <div class="text-center text-base text-gray-500 mt-5">
                            <p >Tidak ada data servis yang tersedia.</p>
                        </div>
                    @endif
                @endif
            </div>
    </div>     
</x-app-layout>