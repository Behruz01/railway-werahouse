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
                                            <!-- Order Number -->
                                            <input wire:model.defer='order_number' name="order_number" type="number" class="form-control mb-3" id="order_number" placeholder="{{ $order->order_number }}" aria-label="order_number">

                                            <!-- Description -->
                                            <textarea wire:model.defer="description" name="description" class="form-control mb-3" id="description" placeholder="{{ $order->description }}" aria-label="description" required></textarea>

                                            <!-- Select Wagon -->
                                            <select wire:model.defer="wagon_id" class="form-control mb-3">
                                                <option value="">Select Wagon</option>
                                                @foreach(\App\Models\Wagon::all() as $wagon)
                                                    <option value="{{ $wagon->id }}" {{ $wagon->id == $order->wagon_id ? 'selected' : '' }}>{{ $wagon->wagon_number }}</option>
                                                @endforeach
                                            </select>

                                            <!-- Status -->
                                            <select wire:model.defer="status" class="form-control mb-3" required>
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>

                                            <!-- Delivery Date -->
                                            <input wire:model.defer="delivery_date" type="date" class="form-control mb-3" value="{{ $order->delivery_date }}" required>
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
                        <!-- Select User -->
                        <select wire:model.defer="user_id" class="form-control mb-3" required>
                            <option value="">Select User</option>
                            @foreach(\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}">{{ $user->email }}</option>
                            @endforeach
                        </select>

                        <!-- Select Wagon -->
                        <select wire:model.defer="wagon_id" class="form-control mb-3" required>
                            <option value="">Select Wagon</option>
                            @foreach(\App\Models\Wagon::all() as $wagon)
                                <option value="{{ $wagon->id }}">{{ $wagon->wagon_number }}</option>
                            @endforeach
                        </select>

                        <!-- Order Number -->
                        <input wire:model.defer="order_number" type="text" class="form-control mb-3" placeholder="Order Number" required>

                        <!-- Description -->
                        <textarea wire:model.defer="description" class="form-control mb-3" placeholder="Description" required></textarea>

                        <!-- Status -->
                        <select wire:model.defer="status" class="form-control mb-3" required>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>

                        <!-- Delivery Date -->
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

       <!--Updated Toast -->
    <div x-data="{ open: false }" x-init="
        @this.on('notify-updated', () => {
            if (open === false) setTimeout(() => { open = false }, 2500);
            open = true;

        });" x-show.transition.out.duration.1500ms="open" style="display: none;">

        <div id="renamedToast" class="position-fixed toast show" role="alert" aria-live="assertive" aria-atomic="true" style="top: 20px; right: 20px; z-index: 1000;">
            <div class="toast-header">
                <div class="d-flex align-items-center flex-grow-1">
                <div class="flex-shrink-0">
                    <img class="avatar avatar-sm avatar-circle" src="{{ asset('admin-assets/img/others/success-icon.png') }}" alt="Image description">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h5 class="mb-0">Order updated!</h5>
                    <small class="ms-auto">{{ now()->diffForHumans() }}</small>
                </div>
                <div class="text-end">
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Updated Toast -->

    <!--Deleted Toast -->
    <div x-data="{ open: false }" x-init="
        @this.on('notify-deleted', () => {
            if (open === false) setTimeout(() => { open = false }, 2500);
            open = true;

        });" x-show.transition.out.duration.1500ms="open" style="display: none;">

        <div id="deletedToast" class="position-fixed toast show" role="alert" aria-live="assertive" aria-atomic="true" style="top: 20px; right: 20px; z-index: 1000;">
            <div class="toast-header">
                <div class="d-flex align-items-center flex-grow-1">
                <div class="flex-shrink-0">
                    <img class="avatar avatar-sm avatar-circle" src="{{ asset('admin-assets/img/others/success-icon.png') }}" alt="Image description">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h5 class="mb-0">Order deleted!</h5>
                    <small class="ms-auto">{{ now()->diffForHumans() }}</small>
                </div>
                <div class="text-end">
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Deleted Toast -->

    <!--created Toast -->
    <div x-data="{ open: false }" x-init="
        @this.on('notify-created', () => {
            if (open === false) setTimeout(() => { open = false }, 2500);
            open = true;

        });" x-show.transition.out.duration.1500ms="open" style="display: none;">

        <div id="renamedToast" class="position-fixed toast show" role="alert" aria-live="assertive" aria-atomic="true" style="top: 20px; right: 20px; z-index: 1000;">
            <div class="toast-header">
                <div class="d-flex align-items-center flex-grow-1">
                <div class="flex-shrink-0">
                    <img class="avatar avatar-sm avatar-circle" src="{{ asset('admin-assets/img/others/success-icon.png') }}" alt="Image description">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h5 class="mb-0">Order created!</h5>
                    <small class="ms-auto">{{ now()->diffForHumans() }}</small>
                </div>
                <div class="text-end">
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End created Toast -->

    @push('scripts')
        <script>
            window.addEventListener('notify-updated', event => {
                $('#editOrderModal'+event.detail.van).modal('hide');
                $('.modal-backdrop').remove();
            });
            window.addEventListener('notify-deleted', event => {
                $('#deleteOrderModal'+event.detail.van).modal('hide');
                $('.modal-backdrop').remove();
            });
            window.addEventListener('notify-created', event => {
                $('#addOrderModal').modal('hide');
                $('.modal-backdrop').remove();
            });
        </script>
    @endpush
</div>
