<?php

namespace App\Http\Livewire\Admin\Blog\Post;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $totalItemsCount;
    public $publishItemsCount;
    public $privateItemsCount;
    public $draftItemsCount;
    public $scheduledPublishItemsCount;
    public $trashedItemsCount;
    public $statusFilter;
    public $trashFilter;
    public $search;

    public function mount()
    {
        $this->totalItemsCount = Post::loggedOwner('post_author_id')->withTrashed()->count();
        $this->publishItemsCount = Post::loggedOwner('post_author_id')->publish()->count();
        $this->privateItemsCount = Post::loggedOwner('post_author_id')->private()->count();
        $this->draftItemsCount = Post::loggedOwner('post_author_id')->draft()->count();
        $this->scheduledPublishItemsCount = Post::loggedOwner('post_author_id')->scheduledPublish()->count();
        $this->trashedItemsCount = Post::loggedOwner('post_author_id')->onlyTrashed()->count();
    }

    public function render()
    {
        $posts = Post::status($this->statusFilter)
            ->trash($this->trashFilter)
            ->search($this->search)
            ->loggedOwner('post_author_id')
            ->latest()->paginate(20);

        return view('livewire.admin.blog.post.index', compact('posts'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setFilter($type, $value)
    {
        $this->resetPage();
        if ($type == 'status') {
            $this->statusFilter = $value;
            $this->trashFilter = false;
        } elseif ($type == 'trash') {
            $this->statusFilter = null;
            $this->trashFilter = $value;
        }
    }
}
