@extends('layouts.layout')

@section('title')
    <title>My Orders</title>
@endsection

@section('content')
<main id="content" role="main" class="main">
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">My Orders</h1>
        </div>

        <div class="mb-3">
            <a href="{{ route('orders.create') }}" class="btn btn-primary">
                Create New Order
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                @if($orders->isEmpty())
                    <p>No orders yet.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
