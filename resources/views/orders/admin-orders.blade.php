@section('title', 'Kelola Data Pesanan')
<x-app-layout>
    <div class=" mt-10 max-w-7xl mx-auto px-3 py-10 sm:px-6 lg:px-8">
        @if (session()->has('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show" x-transition>
                    <x-alert message="{{ session('success') }}" />
                </div>
        @endif

        <div class=" flex my-6 items-center justify-between">
            <h2 class="font-semibold font-xl text-secondary">Tabel Data Pesanan</h2>
            <div class="flex gap-1">
                 @include('orders.partials.add-orders')
                <a href="{{ route('orders.export') }}">
                    <button class="btn btn-sm btn-success text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="w-4 h-4 fill-white">
                            <path d="M64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-288-128 0c-17.7 0-32-14.3-32-32L224 0 64 0zM256 0l0 128 128 0L256 0zM155.7 250.2L192 302.1l36.3-51.9c7.6-10.9 22.6-13.5 33.4-5.9s13.5 22.6 5.9 33.4L221.3 344l46.4 66.2c7.6 10.9 5 25.8-5.9 33.4s-25.8 5-33.4-5.9L192 385.8l-36.3 51.9c-7.6 10.9-22.6 13.5-33.4 5.9s-13.5-22.6-5.9-33.4L162.7 344l-46.4-66.2c-7.6-10.9-5-25.8 5.9-33.4s25.8-5 33.4 5.9z"/>
                        </svg>
                        Download
                    </button>
                </a>
            </div>
            
        </div>
        <table class="table table-zebra w-full">
            <thead>
                <tr class="text-secondary text-base font-semibold">
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Pembeli</th>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Kuantitas</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                <tr class="text-primary">
                    <td>{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                    <td>{{ $order->invoice }}</td>
                    <td>{{ $order->pembeli }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->tanggal_pembelian)->format('d/m/Y') }}</td>
                    <td>
                        <ul class="list-disc ml-4">
                            @foreach($order->products as $product)
                                <li>{{ $product->title }} (x{{ $product->pivot->kuantitas }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $order->products->sum('pivot.kuantitas') }}</td>
                    <td>{{ $order->alamat_pengiriman }}</td>
                    <td>
                         @include('orders.partials.edit-orders', ['order' => $order, 'index' => $loop->iteration])
                         @include('orders.partials.delete-orders', ['order' => $order, 'index' => $loop->iteration])
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
    </div>
</x-app-layout>