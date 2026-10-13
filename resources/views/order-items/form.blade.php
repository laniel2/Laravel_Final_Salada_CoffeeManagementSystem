@extends('layouts.app')

@section('title', $record->exists ? 'Edit Order Items' : 'Add Order Items')
@section('heading', $record->exists ? 'Edit Order Items' : 'Add Order Items')

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ $record->exists ? route('order-items.update', $record) : route('order-items.store') }}">
                @csrf

                @if($record->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label" for="order_id">Order ID</label>
                    <input class="form-control" id="order_id" name="order_id" type="number" value="{{ old('order_id', $record->order_id) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="product_id">Product ID</label>
                    <input class="form-control" id="product_id" name="product_id" type="number" value="{{ old('product_id', $record->product_id) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="quantity">Quantity</label>
                    <input class="form-control" id="quantity" name="quantity" type="number" value="{{ old('quantity', $record->quantity) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="unit_price">Unit Price</label>
                    <input class="form-control" id="unit_price" name="unit_price" type="number" step="0.01" value="{{ old('unit_price', $record->unit_price) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="subtotal">Subtotal</label>
                    <input class="form-control" id="subtotal" name="subtotal" type="number" step="0.01" value="{{ old('subtotal', $record->subtotal) }}" required>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Save</button>
                    <a class="btn btn-secondary" href="{{ route('order-items.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection