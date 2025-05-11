<div>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="mb-2 col-sm mb-sm-0">
                    <h1 class="page-header-title">Wagons</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Wagons</li>
                    </ul>
                </div>
                <!-- End Col -->

                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="javascript:;" data-bs-toggle="modal" data-bs-target="#addWagonModal">
                        <i class="bi-truck me-1"></i> Add wagon
                    </a>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header card-header-content-md-between">
                <div class="mb-2 mb-md-0">
                    <form>
                        <!-- Search -->
                        <div class="input-group input-group-merge input-group-flush">
                            <div class="input-group-prepend input-group-text">
                                <i class="bi-search"></i>
                            </div>
                            <input id="datatableSearch" type="search" class="form-control" placeholder="Search wagons" aria-label="Search wagons" />
                        </div>
                        <!-- End Search -->
                    </form>
                </div>

                <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
                    <!-- Datatable Info -->
                    <div id="datatableCounterInfo" style="display: none;">
                        <div class="d-flex align-items-center">
                            <span class="fs-5 me-3">
                                <span id="datatableCounter">0</span>
                                Selected
                            </span>
                            <a class="btn btn-outline-danger btn-sm" href="javascript:;"> <i class="bi-trash"></i> Delete </a>
                        </div>
                    </div>
                    <!-- End Datatable Info -->

                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom position-relative">
                <table
                    id="datatable"
                    class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                    data-hs-datatables-options='{
                        "columnDefs": [{
                            "targets": [0, 7],
                            "orderable": false
                            }],
                        "order": [],
                        "info": {
                            "totalQty": "#datatableWithPaginationInfoTotalQty"
                        },
                        "search": "#datatableSearch",
                        "entries": "#datatableEntries",
                        "pageLength": 15,
                        "isResponsive": false,
                        "isShowPaging": false,
                        "pagination": "datatablePagination"
                        }'
                >
                    <thead class="thead-light">
                        <tr>
                            <th class="table-column-pe-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll" />
                                    <label class="form-check-label" for="datatableCheckAll"></label>
                                </div>
                            </th>
                            <th class="table-column-ps-0">Van ID</th>
                            <th>Wagon number</th>
                            <th>Capacity (T)</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($wagons as $wagon)
                        <tr>
                            <td class="table-column-pe-0">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll1" />
                                        <label class="form-check-label" for="datatableCheckAll1"></label>
                                    </div>
                                </td>
                            <td class="table-column-ps-0">
                                <span class="mb-0 d-block h5">{{ $wagon->van_id }}</span>
                            </td>
                            <td>
                                <span class="mb-0 d-block h5">{{ $wagon->wagon_number }}</span>
                            </td>
                            <td>
                                <span class="mb-0 d-block h5">{{ $wagon->capacity }}</span>
                            </td>
                            <td>
                                <span class="mb-0 d-block h5">{{ $wagon->status }}</span>
                            </td>

                            <td>
                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editWagonModal{{ $wagon->id }}" class="btn btn-white btn-sm"><i class="bi-pencil-fill me-1"></i> Edit</a>
                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#deleteWagonModal{{ $wagon->id }}" class="btn btn-white btn-sm"><i class="bi-trash-fill me-1"></i> Delete</a>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editWagonModal{{ $wagon->id }}" tabindex="-1" aria-labelledby="editWagonModalLabel{{ $wagon->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="editWagonModalLabel{{ $wagon->id }}">Update {{ $wagon->id.' ('.$wagon->wagon_number.' '.$wagon->capacity.' '.$wagon->status.')' }}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <!-- Body -->
                                    <div class="modal-body">
                                        <form wire:submit.prevent='update({{ $wagon->id }})'>
                                            <!-- Van ID -->
                                            <div class="row mb-4">
                                                <div class="col-sm-3 mb-2 mb-sm-0">
                                                    <div class="d-flex align-items-center mt-2">
                                                        <i class="bi-truck nav-icon"></i>
                                                        <div class="flex-grow-1">Van ID</div>
                                                    </div>
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-sm">
                                                    <label for="van_id" class="visually-hidden form-label">Van ID</label>

                                                    <input wire:model.defer='van_id' name="van_id" type="text" class="form-control" id="van_id" placeholder="{{ $wagon->van_id }}" aria-label="Van ID">
                                                </div>
                                                <!-- End Col -->
                                            </div>
                                            <!-- End Van ID -->

                                            <!-- Wagon Number -->
                                            <div class="row mb-4">
                                                <div class="col-sm-3 mb-2 mb-sm-0">
                                                    <div class="d-flex align-items-center mt-2">
                                                        <i class="bi-truck nav-icon"></i>
                                                        <div class="flex-grow-1">Wagon N</div>
                                                    </div>
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-sm">
                                                    <label for="wagon_number" class="visually-hidden form-label">Wagon N</label>

                                                    <input wire:wagon_number.defer='wagon_number' name="wagon_number" type="text" class="form-control" id="wagon_number" placeholder="{{ $wagon->wagon_number }}" aria-label="Wagon N">
                                                </div>
                                                <!-- End Col -->
                                            </div>
                                            <!-- End Wagon Number -->

                                            <!-- Capacity -->
                                            <div class="row mb-4">
                                                <div class="col-sm-3 mb-2 mb-sm-0">
                                                    <div class="d-flex align-items-center mt-2">
                                                        <i class="bi-truck nav-icon"></i>
                                                        <div class="flex-grow-1">Capacity</div>
                                                    </div>
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-sm">
                                                    <label for="capacity" class="visually-hidden form-label">Capacity</label>

                                                    <input wire:model.defer='capacity' name="capacity" type="number" class="form-control" id="capacity" placeholder="{{ $wagon->capacity }}" aria-label="Capacity">
                                                </div>
                                                <!-- End Col -->
                                            </div>
                                            <!-- End Capacity -->

                                            <!-- Status -->
                                            <div class="row mb-4">
                                                <div class="col-sm-3 mb-2 mb-sm-0">
                                                    <div class="d-flex align-items-center mt-2">
                                                        <i class="bi-truck nav-icon"></i>
                                                        <div class="flex-grow-1">Status</div>
                                                    </div>
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-sm">
                                                    <label for="status" class="visually-hidden form-label">Status</label>

                                                    <input wire:model.defer='status' name="status" type="text" class="form-control" id="status" placeholder="{{ $wagon->status }}" aria-label="Status">
                                                </div>
                                                <!-- End Col -->
                                            </div>
                                            <!-- End Status -->

                                    </div>
                                    <!-- End Body -->

                                    <!-- Footer -->
                                    <div class="modal-footer gap-3">
                                        <button type="button" id="discardFormt" class="btn btn-white" data-bs-dismiss="modal">Discard</button>
                                        <button type="submit" id="processEvent" class="btn btn-primary">Update wagon</button>
                                    </div>
                                    <!-- End Footer -->
                                </form>

                                </div>
                            </div>
                        </div>
                        <!-- End Edit Modal -->

                        <!-- Delete Wagon Modal -->
                        <div class="modal fade" id="deleteWagonModal{{ $wagon->id }}" tabindex="-1" aria-labelledby="deleteWagonModalLabel{{ $wagon->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="deleteWagonModalLabel{{ $wagon->id }}">Delete {{ $wagon->id.' ('.$wagon->wagon_number.' '.$wagon->capacity.' '.$wagon->status.')' }} ?</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <!-- Body -->
                                    <div class="modal-body">
                                        <p>Are you sure?</p>
                                        <p>This action will delete all associated shifts with this van and is irreversible.</p>
                                    </div>
                                    <!-- End Body -->
                                    <!-- Footer -->
                                    <div class="card-footer d-sm-flex align-items-sm-center">
                                        <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-ghost-secondary">
                                            <i class="bi-chevron-left"></i> Cancel
                                        </button>

                                        <div class="ms-auto">
                                            <button wire:click='delete({{ $wagon->id }})' type="button" class="btn btn-danger">
                                                Yes, delete <i class="bi-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- End Footer -->
                                </div>
                            </div>
                        </div>
                        <!-- End delete folder Modal -->

                        @empty
                        {{--  <p>No driver data found</p>  --}}
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer">
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                            <span class="me-2">Showing:</span>

                            <!-- Select -->
                            <div class="tom-select-custom">
                                <select
                                    id="datatableEntries"
                                    class="js-select form-select form-select-borderless w-auto"
                                    autocomplete="off"
                                    data-hs-tom-select-options='{
                                    "searchInDropdown": false,
                                    "hideSearch": true
                                }'
                                >
                                    <option value="10">10</option>
                                    <option value="15" selected>15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <!-- End Select -->

                            <span class="text-secondary me-2">of</span>

                            <!-- Pagination Quantity -->
                            <span id="datatableWithPaginationInfoTotalQty"></span>
                        </div>
                    </div>
                    <!-- End Col -->

                    <div class="col-sm-auto">
                        <div class="d-flex justify-content-center justify-content-sm-end">
                            <!-- Pagination -->
                            <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                        </div>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->

    </div>

    <!-- Create a new Wagon -->
    <div class="modal fade" id="addWagonModal" tabindex="-1" aria-labelledby="addWagonModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addWagonModalLabel">Add Wagon to Train</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form wire:submit.prevent='addWagon'>
                        <!-- Van ID -->
                        <div class="row mb-4">
                            <div class="col-sm-3 mb-2 mb-sm-0">
                                <div class="d-flex align-items-center mt-2">
                                    <i class="bi-truck nav-icon"></i>
                                    <div class="flex-grow-1">Van ID</div>
                                </div>
                            </div>
                            <!-- End Col -->

                            <div class="col-sm">
                                <label for="van_id" class="visually-hidden form-label">Van ID</label>

                                <input wire:model.defer='van_id' name="van_id" type="text" class="form-control" id="van_id" placeholder="Van ID" aria-label="van_id" required>
                                @error('van_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Van ID -->

                        <!-- Wagon number -->
                        <div class="row mb-4">
                            <div class="col-sm-3 mb-2 mb-sm-0">
                                <div class="d-flex align-items-center mt-2">
                                    <i class="bi-truck nav-icon"></i>
                                    <div class="flex-grow-1">Wagon n</div>
                                </div>
                            </div>
                            <!-- End Col -->

                            <div class="col-sm">
                                <label for="wagon_number" class="visually-hidden form-label">Wagon number</label>

                                <input wire:model.defer='wagon_number' name="wagon_number" type="text" class="form-control" id="wagon_number" placeholder="Wagon number" aria-label="Wagon number">
                                @error('wagon_number') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Wagon number -->

                        <!-- Capacity -->
                        <div class="row mb-4">
                            <div class="col-sm-3 mb-2 mb-sm-0">
                                <div class="d-flex align-items-center mt-2">
                                    <i class="bi-truck nav-icon"></i>
                                    <div class="flex-grow-1">Capacity</div>
                                </div>
                            </div>
                            <!-- End Col -->

                            <div class="col-sm">
                                <label for="capacity" class="visually-hidden form-label">Capacity</label>

                                <input wire:model.defer='capacity' name="capacity" type="number" class="form-control" id="capacity" placeholder="Capacity" aria-label="Capacity">
                                @error('capacity') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Capacity -->

                        <!-- Status -->
                        <div class="row mb-4">
                            <div class="col-sm-3 mb-2 mb-sm-0">
                                <div class="d-flex align-items-center mt-2">
                                    <i class="bi-truck nav-icon"></i>
                                    <div class="flex-grow-1">Status</div>
                                </div>
                            </div>
                            <!-- End Col -->

                            <div class="col-sm">
                                <label for="status" class="visually-hidden form-label">Status</label>

                                <input wire:model.defer='status' name="status" type="text" class="form-control" id="status" placeholder="Status" aria-label="Status">
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Status -->

                </div>
                <!-- End Body -->

                <!-- Footer -->
                <div class="modal-footer gap-3">
                    <button type="button" id="discardFormt" class="btn btn-white" data-bs-dismiss="modal">Discard</button>
                    <button type="submit" id="processEvent" class="btn btn-primary">Create wagon</button>
                </div>
                <!-- End Footer -->
            </form>

            </div>
        </div>
    </div>
    <!-- End Create a new Wagon Modal -->

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
                    <h5 class="mb-0">Wagon updated!</h5>
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
                    <h5 class="mb-0">Wagon deleted!</h5>
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
                    <h5 class="mb-0">Wagon created!</h5>
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
                $('#editWagonModal'+event.detail.wagon).modal('hide');
                $('.modal-backdrop').remove();
            });
            window.addEventListener('notify-deleted', event => {
                $('#deleteWagonModal'+event.detail.wagon).modal('hide');
                $('.modal-backdrop').remove();
            });
            window.addEventListener('notify-created', event => {
                $('#addWagonModal').modal('hide');
                $('.modal-backdrop').remove();
            });
        </script>
    @endpush
</div>
