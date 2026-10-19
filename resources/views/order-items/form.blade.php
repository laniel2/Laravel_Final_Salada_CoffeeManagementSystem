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
                    <label class="form-label" for="order_id">Order</label>
                    <select class="form-select" id="order_id" name="order_id" required>
                        <option value="">Choose an order</option>
                        @foreach($orders as $order)
                            <option value="{{ $order->id }}" @selected(old('order_id', $record->order_id) == $order->id)>#{{ $order->id }} · {{ $order->customer->name }} · {{ $order->order_date->format('M j, Y') }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="product_id">Product</label>
                    <select class="form-select" id="product_id" name="product_id" required>
                        <option value="">Choose a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @selected(old('product_id', $record->product_id) == $product->id)>{{ $product->name }} · ${{ number_format($product->price, 2) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="quantity">Quantity</label>
                    <input class="form-control" id="quantity" name="quantity" type="number" min="1" value="{{ old('quantity', $record->quantity ?? 1) }}" required>
                </div>

                <p class="form-text">Price and subtotal are calculated from the selected product and quantity.</p>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Save</button>
                    <a class="btn btn-secondary" href="{{ route('order-items.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
