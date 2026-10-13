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
                    <label class="form-label" for="customer_id">Customer ID</label>
                    <input class="form-control" id="customer_id" name="customer_id" type="number" value="{{ old('customer_id', $record->customer_id) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="order_date">Order Date</label>
                    <input class="form-control" id="order_date" name="order_date" type="datetime-local" value="{{ old('order_date', $record->order_date) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="status">Status (pending/preparing/completed/cancelled)</label>
                    <input class="form-control" id="status" name="status" type="text" value="{{ old('status', $record->status) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="total_amount">Total Amount</label>
                    <input class="form-control" id="total_amount" name="total_amount" type="number" step="0.01" value="{{ old('total_amount', $record->total_amount) }}" required>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Save</button>
                    <a class="btn btn-secondary" href="{{ route('orders.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection