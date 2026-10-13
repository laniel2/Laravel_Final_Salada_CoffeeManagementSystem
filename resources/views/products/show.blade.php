@extends('layouts.app')

@section('title', 'View Products')
@section('heading', 'View Products')

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Category ID:</strong> {{ $record->category_id ?? '—' }}</p>
            <p><strong>Product Name:</strong> {{ $record->name ?? '—' }}</p>
            <p><strong>Description:</strong> {{ $record->description ?? '—' }}</p>
            <p><strong>Price:</strong> {{ $record->price ?? '—' }}</p>
            <p><strong>Stock:</strong> {{ $record->stock ?? '—' }}</p>

            <a class="btn btn-primary" href="{{ route('products.edit', $record) }}">Edit</a>
            <a class="btn btn-secondary" href="{{ route('products.index') }}">Back</a>
        </div>
    </div>
@endsection
