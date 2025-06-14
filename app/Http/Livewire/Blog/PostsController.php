<?php

namespace App\Http\Livewire\Blog;

use App\Models\Post;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class PostsController extends Component
{
    use WithPagination;

    public string $search = '';
    public string $perPage = '10';
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';
    public bool $showOnlyPublished = false;

    protected $queryString = ['search', 'perPage', 'sortBy', 'sortDirection', 'showOnlyPublished'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function togglePublished(int $postId): void
    {
        $post = Post::findOrFail($postId);
        $post->update(['status' => !$post->status]);
        $this->dispatch('success-toast', ['message' => 'Status toggled!']);
    }

    public function deletePost(int $postId): void
    {
        Post::findOrFail($postId)->delete();
        $this->dispatch('success-toast', ['message' => 'Post deleted!']);
        $this->resetPage(); // handle empty-page edge
    }

    public function updatingSortBy(): void
    {
        $this->sortDirection = 'asc';
    }
    public function sort(string $field): void
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function render(): View
    {
        $query = Post::query()
            ->when($this->search, fn($q) =>
            $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->showOnlyPublished, fn($q) => $q->where('status', true))
            ->orderBy($this->sortBy, $this->sortDirection);

        $posts = $query->paginate($this->perPage);

        return view('livewire.blog.posts-index', compact('posts'));
    }
}
