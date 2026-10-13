@extends('layouts.app')

@section('title', 'View Orders')
@section('heading', 'View Orders')

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Customer ID:</strong> {{ $record->customer_id ?? '—' }}</p>
            <p><strong>Order Date:</strong> {{ $record->order_date ?? '—' }}</p>
            <p><strong>Status:</strong> {{ $record->status ?? '—' }}</p>
            <p><strong>Total Amount:</strong> {{ $record->total_amount ?? '—' }}</p>

            <a class="btn btn-primary" href="{{ route('orders.edit', $record) }}">Edit</a>
            <a class="btn btn-secondary" href="{{ route('orders.index') }}">Back</a>
        </div>
    </div>
@endsection
