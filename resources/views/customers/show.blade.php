@extends('layouts.app')

@section('title', 'View Customers')
@section('heading', 'View Customers')

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Customer Name:</strong> {{ $record->name ?? '—' }}</p>
            <p><strong>Email:</strong> {{ $record->email ?? '—' }}</p>
            <p><strong>Phone:</strong> {{ $record->phone ?? '—' }}</p>
            <p><strong>Address:</strong> {{ $record->address ?? '—' }}</p>

            <h2 class="h5 mt-4">Orders</h2>
            @forelse($record->orders as $order)
                <div><a href="{{ route('orders.show', $order) }}">Order #{{ $order->id }}</a> · {{ ucfirst($order->status) }} · {{ number_format($order->total_amount, 2) }}</div>
            @empty
                <p class="text-muted">This customer has no orders.</p>
            @endforelse

            <a class="btn btn-primary" href="{{ route('customers.edit', $record) }}">Edit</a>
            <a class="btn btn-secondary" href="{{ route('customers.index') }}">Back</a>
        </div>
    </div>
@endsection
