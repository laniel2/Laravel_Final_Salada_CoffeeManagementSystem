@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Coffee Shop Management Dashboard')

@section('content')
    <div class="row g-3">
        @foreach([
            ['categories.index', 'Categories', 'Manage product groups'],
            ['products.index', 'Products', 'Manage menu and stock'],
            ['customers.index', 'Customers', 'Customer contact details'],
            ['orders.index', 'Orders', 'Track customer orders'],
            ['order-items.index', 'Order Items', 'Manage items inside orders'],
        ] as [$routeName, $name, $desc])
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h2 class="h5">{{ $name }}</h2>
                        <p class="text-muted">{{ $desc }}</p>
                        <a class="btn btn-primary" href="{{ route($routeName) }}">Open {{ $name }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <p class="text-muted mt-4">Simple coffee shop record management using Laravel, Blade, Bootstrap, and MySQL.</p>
@endsection
