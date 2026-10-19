@extends('layouts.app')

@section('title', 'View Orders')
@section('heading', 'View Orders')

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Customer:</strong> {{ $record->customer?->name ?? '—' }} ({{ $record->customer?->email ?? '—' }})</p>
            <p><strong>Order Date:</strong> {{ $record->order_date ?? '—' }}</p>
            <p><strong>Status:</strong> {{ $record->status ?? '—' }}</p>
            <p><strong>Total Amount:</strong> {{ $record->total_amount ?? '—' }}</p>

            <h2 class="h5 mt-4">Items</h2>
            @if($record->items->isEmpty())
                <p class="text-muted">No items have been added to this order.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead><tr><th>Product</th><th>Quantity</th><th>Unit price</th><th>Subtotal</th></tr></thead>
                        <tbody>
                            @foreach($record->items as $item)
                                <tr><td>{{ $item->product?->name ?? 'Deleted product' }}</td><td>{{ $item->quantity }}</td><td>{{ number_format($item->unit_price, 2) }}</td><td>{{ number_format($item->subtotal, 2) }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <a class="btn btn-outline-primary mb-3" href="{{ route('order-items.create') }}">Add Order Item</a>

            <a class="btn btn-primary" href="{{ route('orders.edit', $record) }}">Edit</a>
            <a class="btn btn-secondary" href="{{ route('orders.index') }}">Back</a>
        </div>
    </div>
@endsection
