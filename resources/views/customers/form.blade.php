@extends('layouts.app')

@section('title', $record->exists ? 'Edit Customers' : 'Add Customers')
@section('heading', $record->exists ? 'Edit Customers' : 'Add Customers')

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ $record->exists ? route('customers.update', $record) : route('customers.store') }}">
                @csrf

                @if($record->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label" for="name">Customer Name</label>
                    <input class="form-control" id="name" name="name" type="text" value="{{ old('name', $record->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ old('email', $record->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="phone">Phone</label>
                    <input class="form-control" id="phone" name="phone" type="text" value="{{ old('phone', $record->phone) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $record->address) }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Save</button>
                    <a class="btn btn-secondary" href="{{ route('customers.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection