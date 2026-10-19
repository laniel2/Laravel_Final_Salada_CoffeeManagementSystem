@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Coffee Shop Management Dashboard')

@section('content')
    <div class="row g-3 mb-4">
        @foreach([
            ['Products', $stats['products']],
            ['Categories', $stats['categories']],
            ['Customers', $stats['customers']],
            ['Orders', $stats['orders']],
            ['Order Items', $stats['order_items']],
            ['Completed Sales', number_format($stats['sales'], 2)],
        ] as [$label, $value])
            <div class="col-6 col-lg-4">
                <div class="card h-100 shadow-sm"><div class="card-body">
                    <div class="text-muted small">{{ $label }}</div>
                    <div class="fs-3 fw-semibold">{{ $value }}</div>
                </div></div>
            </div>
        @endforeach
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header bg-white fw-semibold">Recent Orders</div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead><tr><th>Order</th><th>Customer</th><th>Status</th><th>Total</th></tr></thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td><a href="{{ route('orders.show', $order) }}">#{{ $order->id }}</a></td>
                                    <td>{{ $order->customer?->name ?? '—' }}</td>
                                    <td><span class="badge text-bg-secondary">{{ ucfirst($order->status) }}</span></td>
                                    <td>{{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">No orders yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header bg-white fw-semibold">Low Stock (5 or fewer)</div>
                <ul class="list-group list-group-flush">
                    @forelse($lowStockProducts as $product)
                        <li class="list-group-item d-flex justify-content-between">
                            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                            <span class="badge text-bg-warning">{{ $product->stock }} left</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No low stock products.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

@endsection
