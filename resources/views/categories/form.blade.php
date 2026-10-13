@extends('layouts.app')

@section('title', $record->exists ? 'Edit Categories' : 'Add Categories')
@section('heading', $record->exists ? 'Edit Categories' : 'Add Categories')

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ $record->exists ? route('categories.update', $record) : route('categories.store') }}">
                @csrf

                @if($record->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input class="form-control" id="name" name="name" type="text" value="{{ old('name', $record->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $record->description) }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Save</button>
                    <a class="btn btn-secondary" href="{{ route('categories.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection