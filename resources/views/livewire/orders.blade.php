<div>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="mb-2 col-sm mb-sm-0">
                    <h1 class="page-header-title">Orders</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ul>
                </div>
                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="javascript:;" data-bs-toggle="modal" data-bs-target="#addOrderModal">
                        <i class="bi-cart-plus me-1"></i> Add Order
                    </a>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="card">
            <div class="card-header card-header-content-md-between">
                <form>
                    <div class="input-group input-group-merge input-group-flush">
                        <div class="input-group-prepend input-group-text">
                            <i class="bi-search"></i>
                        </div>
                        <input id="datatableSearch" type="search" class="form-control" placeholder="Search orders" aria-label="Search orders" />
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive datatable-custom position-relative">
                <table class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Order #</th>
                            <th>User</th>
                            <th>Wagon</th>
                            <th>Status</th>
                            <th>Delivery Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>{{ $order->wagon->wagon_number ?? 'None' }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ $order->delivery_date }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-white" data-bs-toggle="modal" data-bs-target="#editOrderModal{{ $order->id }}"><i class="bi-pencil-fill me-1"></i> Edit</a>
                                <a href="#" class="btn btn-sm btn-white" data-bs-toggle="modal" data-bs-target="#deleteOrderModal{{ $order->id }}"><i class="bi-trash-fill me-1"></i> Delete</a>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editOrderModal{{ $order->id }}" tabindex="-1" aria-labelledby="editOrderLabel{{ $order->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form wire:submit.prevent="update({{ $order->id }})">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="editOrderLabel{{ $order->id }}">Edit Order #{{ $order->order_number }}</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Only these fields should remain -->
                                            <select wire:model.defer="wagon_id" class="form-control mb-3">
                                                <option value="">Select Wagon</option>
                                                @foreach(\App\Models\Wagon::all() as $wagon)
                                                    <option value="{{ $wagon->id }}">{{ $wagon->wagon_number }}</option>
                                                @endforeach
                                            </select>

                                            <select wire:model.defer="status" class="form-control mb-3">
                                                <option value="pending">Pending</option>
                                                <option value="processing">Processing</option>
                                                <option value="completed">Completed</option>
                                                <option value="cancelled">Cancelled</option>
                                            </select>

                                            <input wire:model.defer="delivery_date" type="date" class="form-control mb-3">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteOrderModal{{ $order->id }}" tabindex="-1" aria-labelledby="deleteOrderLabel{{ $order->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete Order #{{ $order->order_number }}?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this order?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
                                        <button wire:click="delete({{ $order->id }})" class="btn btn-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr><td colspan="7" class="text-center">No orders found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Order Modal -->
    <div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="addOrder">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addOrderModalLabel">Add Order</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input wire:model.defer="order_number" type="text" class="form-control mb-3" placeholder="Order Number" required>
                        <textarea wire:model.defer="description" class="form-control mb-3" placeholder="Description" required></textarea>
                        <select wire:model.defer="status" class="form-control mb-3">
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <input wire:model.defer="delivery_date" type="date" class="form-control mb-3" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
