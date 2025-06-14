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
            <div class="row align-items-center mb-3">
                <div class="col"><input wire:model.debounce.500ms="search" class="form-control"
                        placeholder="Search titles…">
                </div>
                <div class="col-auto"><input type="number" wire:model.live="perPage" min="5" max="100"
                        class="form-control" /></div>
                <div class="col-auto">
                    <div class="form-check">
                        <input id="publishedOnly" wire:model.live="showOnlyPublished" class="form-check-input"
                            type="checkbox">
                        <label class="form-check-label" for="publishedOnly">Published Only</label>
                    </div>
                </div>
                {{-- <div class="col text-end"><a href="{{ route('blogs.create') }}" class="btn btn-primary"><i
                    class="bi bi-plus-circle"></i> New Post</a>
            </div> --}}
            </div>

            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        @foreach (['title' => 'Title', 'status' => 'Status', 'view_count' => 'Views', 'created_at' => 'Date'] as $field => $label)
                            <th wire:click="sort('{{ $field }}')" style="cursor:pointer">
                                {{ $label }}
                                @if ($sortBy === $field)
                                    <i class="bi bi-caret-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-fill"></i>
                                @endif
                            </th>
                        @endforeach
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td>
                                <button wire:click="togglePublished({{ $post->id }})"
                                    class="btn btn-sm btn-outline-{{ $post->status ? 'success' : 'secondary' }}">
                                    {{ $post->status ? 'Published' : 'Draft' }}
                                </button>
                            </td>
                            <td>{{ $post->view_count }}</td>
                            <td>{{ $post->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('blogs.edit', $post) }}" class="btn btn-sm btn-outline-primary"><i
                                        class="bi bi-pencil"></i></a>
                                <button wire:click="deletePost({{ $post->id }})"
                                    onclick="confirm('Delete?')||event.stopImmediatePropagation()"
                                    class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No posts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center">
                {{ $posts->links() }}
                <small class="text-muted">
                    Showing {{ $posts->firstItem() }}–{{ $posts->lastItem() }} of {{ $posts->total() }}
                </small>
            </div>
        </div>


    </main>

    <!-- End #main -->
    <!-- ======= Footer ======= -->
    @livewire('layouts.footer')
    <!-- End Footer -->
</div>
