@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Orders') }}</span>
                    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">Create New Order</a>
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
                                    <th>Order Number</th>
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
                                        <th>User</th>
                                    @endif
                                    <th>Wagon</th>
                                    <th>Train</th>
                                    <th>Status</th>
                                    <th>Delivery Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->order_number }}</td>
                                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
                                            <td>{{ $order->user->name }}</td>
                                        @endif
                                        <td>{{ $order->wagon ? $order->wagon->wagon_number : 'Not Assigned' }}</td>
                                        <td>{{ $order->wagon ? $order->wagon->train->name : 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'processing' ? 'warning' : ($order->status === 'cancelled' ? 'danger' : 'info')) }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->delivery_date }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('orders.show', $order) }}" class="btn btn-info btn-sm">View</a>
                                                <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager') ? '8' : '7' }}" class="text-center">No orders found.</td>
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
