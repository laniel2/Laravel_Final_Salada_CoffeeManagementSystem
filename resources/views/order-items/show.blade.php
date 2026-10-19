@extends('layouts.app')

@section('title', 'View Order Items')
@section('heading', 'View Order Items')

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Order:</strong> #{{ $record->order_id }} · {{ $record->order?->customer?->name ?? '—' }}</p>
            <p><strong>Product:</strong> {{ $record->product?->name ?? '—' }}</p>
            <p><strong>Quantity:</strong> {{ $record->quantity ?? '—' }}</p>
            <p><strong>Unit Price:</strong> {{ $record->unit_price ?? '—' }}</p>
            <p><strong>Subtotal:</strong> {{ $record->subtotal ?? '—' }}</p>

            <a class="btn btn-primary" href="{{ route('order-items.edit', $record) }}">Edit</a>
            <a class="btn btn-secondary" href="{{ route('order-items.index') }}">Back</a>
        </div>
    </div>
@endsection
