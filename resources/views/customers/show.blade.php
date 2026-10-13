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

            <a class="btn btn-primary" href="{{ route('customers.edit', $record) }}">Edit</a>
            <a class="btn btn-secondary" href="{{ route('customers.index') }}">Back</a>
        </div>
    </div>
@endsection
