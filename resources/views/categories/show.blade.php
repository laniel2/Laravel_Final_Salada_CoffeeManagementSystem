@extends('layouts.app')

@section('title', 'View Categories')
@section('heading', 'View Categories')

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $record->name ?? '—' }}</p>
            <p><strong>Description:</strong> {{ $record->description ?? '—' }}</p>

            <a class="btn btn-primary" href="{{ route('categories.edit', $record) }}">Edit</a>
            <a class="btn btn-secondary" href="{{ route('categories.index') }}">Back</a>
        </div>
    </div>
@endsection
