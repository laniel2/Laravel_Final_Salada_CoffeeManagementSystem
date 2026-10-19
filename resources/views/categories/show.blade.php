@extends('layouts.app')

@section('title', 'View Categories')
@section('heading', 'View Categories')

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $record->name ?? '—' }}</p>
            <p><strong>Description:</strong> {{ $record->description ?? '—' }}</p>

            <h2 class="h5 mt-4">Products</h2>
            @forelse($record->products as $product)
                <div><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a> · {{ number_format($product->price, 2) }}</div>
            @empty
                <p class="text-muted">No products in this category.</p>
            @endforelse

            <a class="btn btn-primary" href="{{ route('categories.edit', $record) }}">Edit</a>
            <a class="btn btn-secondary" href="{{ route('categories.index') }}">Back</a>
        </div>
    </div>
@endsection
