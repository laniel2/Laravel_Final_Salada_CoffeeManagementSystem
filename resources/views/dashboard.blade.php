@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Coffee Shop Management Dashboard')

@section('content')
    <div class="row g-3">
        @foreach([
            ['categories', 'Categories', 'Manage product groups'],
            ['products', 'Products', 'Manage menu and stock'],
            ['customers', 'Customers', 'Customer contact details'],
            ['orders', 'Orders', 'Track customer orders'],
            ['order-items', 'Order Items', 'Manage items inside orders'],
        ] as [$path, $name, $desc])
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h2 class="h5">{{ $name }}</h2>
                        <p class="text-muted">{{ $desc }}</p>
                        <a class="btn btn-primary" href="{{ url('/' . $path) }}">Open {{ $name }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <p class="text-muted mt-4">Simple coffee shop record management using Laravel, Blade, Bootstrap, and MySQL.</p>
@endsection