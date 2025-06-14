@push('title')
    Products
@endpush
<div>
    <!-- ======= Header ======= -->
    <div wire:ignore>
        @livewire('layouts.header')
    </div>
    <hr>
    <!-- End Header -->
    <!-- ======= Sidebar ======= -->
    @livewire('layouts.sidebar')
    <!-- End Sidebar-->
    <main id="main" class="main">
        <div>
            <div class="d-flex justify-content-between align-items-center my-3">
                <h1 class="h4">Products Table</h1>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add
                </a>
            </div>

            <div class="row mb-3">
                <div class="col-md-2">
                    <select class="form-select" wire:model.live="showDataPerPage">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="col-md-4 offset-md-6">
                    <input type="text" class="form-control" placeholder="Search..."
                        wire:model.debounce.500ms="search">
                </div>
            </div>

            @if ($products->isEmpty())
                <div class="alert alert-warning">No products found.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>In Stock</th>
                                <th>Price</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        <img src="{{ asset('storage/products/' . $product->image) }}"
                                            alt="{{ $product->name }}" width="50" height="50">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $product->status ? 'success' : 'secondary' }}">
                                            {{ $product->status ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td>{{ $product->qty_in_stock }}</td>
                                    <td>£{{ number_format($product->sale_price, 2) }}</td>
                                    <td>{{ $product->created_at?->format('M d, Y') }}</td>
                                    <td>
                                        <button wire:click="update({{ $product->id }})"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button wire:click="destroy({{ $product->id }})"
                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation();"
                                            class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $products->links() }} <!-- Livewire 3 native pagination -->
                </div>
            @endif
        </div>

    </main>

    <!-- End #main -->
    <!-- ======= Footer ======= -->
    @livewire('layouts.footer')
    <!-- End Footer -->
</div>
