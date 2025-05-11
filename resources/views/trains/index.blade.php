@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Trains') }}</span>
                    <a href="{{ route('trains.create') }}" class="btn btn-primary btn-sm">Add New Train</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Registration Number</th>
                                    <th>Capacity</th>
                                    <th>Status</th>
                                    <th>Wagons</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($trains as $train)
                                    <tr>
                                        <td>{{ $train->id }}</td>
                                        <td>{{ $train->name }}</td>
                                        <td>{{ $train->registration_number }}</td>
                                        <td>{{ $train->capacity }}</td>
                                        <td>
                                            <span class="badge bg-{{ $train->status === 'active' ? 'success' : ($train->status === 'maintenance' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($train->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $train->wagons->count() }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('trains.show', $train) }}" class="btn btn-info btn-sm">View</a>
                                                <a href="{{ route('trains.edit', $train) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('trains.destroy', $train) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this train?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No trains found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
