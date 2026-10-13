@extends('layouts.app')

@section('title', 'Customers')
@section('heading', 'Customers')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0">Create, view, edit, or delete customers.</p>
        <a class="btn btn-primary" href="{{ route('customers.create') }}">+ Add Customer</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td>{{ $record->id }}</td>
                            <td>{{ $record->name }}</td>
                            <td>{{ $record->email }}</td>
                            <td>{{ $record->phone }}</td>
                            <td>{{ $record->address }}</td>
                            <td class="text-nowrap">
                                <a class="btn btn-sm btn-outline-info" href="{{ route('customers.show', $record) }}">View</a>
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('customers.edit', $record) }}">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('customers.destroy', $record) }}" onsubmit="return confirm('Delete this record?')">
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