@extends('layouts.app')

@section('title', 'Orders')
@section('heading', 'Orders')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0">Create, view, edit, or delete orders.</p>
        <a class="btn btn-primary" href="{{ route('orders.create') }}">+ Add Order</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer ID</th>
                        <th>Order Date</th>
                        <th>Status (pending/preparing/completed/cancelled)</th>
                        <th>Total Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td>{{ $record->id }}</td>
                            <td>{{ $record->customer?->name ?? '—' }}</td>
                            <td>{{ $record->order_date }}</td>
                            <td>{{ $record->status }}</td>
                            <td>{{ $record->total_amount }}</td>
                            <td class="text-nowrap">
                                <a class="btn btn-sm btn-outline-info" href="{{ route('orders.show', $record) }}">View</a>
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('orders.edit', $record) }}">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('orders.destroy', $record) }}" onsubmit="return confirm('Delete this record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No records yet. Add your first record.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $records->links('pagination::bootstrap-5') }}
    </div>
@endsection
