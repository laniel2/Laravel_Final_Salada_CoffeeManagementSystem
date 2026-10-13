@extends('layouts.app')

@section('title', 'Categories')
@section('heading', 'Categories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0">Create, view, edit, or delete categories.</p>
        <a class="btn btn-primary" href="{{ route('categories.create') }}">+ Add Category</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td>{{ $record->id }}</td>
                            <td>{{ $record->name }}</td>
                            <td>{{ $record->description }}</td>
                            <td class="text-nowrap">
                                <a class="btn btn-sm btn-outline-info" href="{{ route('categories.show', $record) }}">View</a>
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('categories.edit', $record) }}">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('categories.destroy', $record) }}" onsubmit="return confirm('Delete this record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">No records yet. Add your first record.</td>
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