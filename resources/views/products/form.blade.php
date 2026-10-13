@extends('layouts.app')

@section('title', $record->exists ? 'Edit Products' : 'Add Products')
@section('heading', $record->exists ? 'Edit Products' : 'Add Products')

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ $record->exists ? route('products.update', $record) : route('products.store') }}">
                @csrf

                @if($record->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label" for="category_id">Category ID</label>
                    <input class="form-control" id="category_id" name="category_id" type="number" value="{{ old('category_id', $record->category_id) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="name">Product Name</label>
                    <input class="form-control" id="name" name="name" type="text" value="{{ old('name', $record->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $record->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="price">Price</label>
                    <input class="form-control" id="price" name="price" type="number" step="0.01" value="{{ old('price', $record->price) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="stock">Stock</label>
                    <input class="form-control" id="stock" name="stock" type="number" value="{{ old('stock', $record->stock) }}" required>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Save</button>
                    <a class="btn btn-secondary" href="{{ route('products.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection