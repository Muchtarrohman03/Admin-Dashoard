<x-app-layout>
    <div class=" mt-10 max-w-7xl mx-auto px-3 py-10 sm:px-6 lg:px-8">
        @if (session()->has('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show" x-transition>
                    <x-alert message="{{ session('success') }}" />
                </div>
        @endif

        <div class=" flex my-6 items-center justify-between">
            <h2 class="font-semibold font-xl text-secondary">Tabel Data Pesanan</h2>
             @include('orders.partials.add-orders')
        </div>
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Pembeli</th>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Kuantitas</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                <tr>
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