@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Wagons') }}</span>
                    <a href="{{ route('wagons.create') }}" class="btn btn-primary btn-sm">Add New Wagon</a>
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
                                    <th>Train</th>
                                    <th>Wagon Number</th>
                                    <th>Capacity</th>
                                    <th>Status</th>
                                    <th>Orders</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($wagons as $wagon)
                                    <tr>
                                        <td>{{ $wagon->id }}</td>
                                        <td>{{ $wagon->train->name }}</td>
                                        <td>{{ $wagon->wagon_number }}</td>
                                        <td>{{ $wagon->capacity }}</td>
                                        <td>
                                            <span class="badge bg-{{ $wagon->status === 'active' ? 'success' : ($wagon->status === 'maintenance' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($wagon->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $wagon->orders->count() }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('wagons.show', $wagon) }}" class="btn btn-info btn-sm">View</a>
                                                <a href="{{ route('wagons.edit', $wagon) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('wagons.destroy', $wagon) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this wagon?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No wagons found.</td>
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
