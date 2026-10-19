@extends('layouts.app')

@section('title', $record->exists ? 'Edit Orders' : 'Add Orders')
@section('heading', $record->exists ? 'Edit Orders' : 'Add Orders')

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ $record->exists ? route('orders.update', $record) : route('orders.store') }}">
                @csrf

                @if($record->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label" for="customer_id">Customer</label>
                    <select class="form-select" id="customer_id" name="customer_id" required>
                        <option value="">Choose a customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" @selected(old('customer_id', $record->customer_id) == $customer->id)>{{ $customer->name }} ({{ $customer->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="order_date">Order Date</label>
                    <input class="form-control" id="order_date" name="order_date" type="datetime-local" value="{{ old('order_date', $record->order_date?->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i')) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        @foreach(['pending', 'preparing', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $record->status ?? 'pending') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <div class="form-text">Order total is calculated automatically from its items.</div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Save</button>
                    <a class="btn btn-secondary" href="{{ route('orders.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
