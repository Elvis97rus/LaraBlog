<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Comments extends Component
{
    public Post $post;

    protected $listeners = [
        'commentCreated' => '$refresh',
        'commentDeleted' => '$refresh',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        $comments = $this->getCommentsByDate();
        $comment_msg = $this->getUnapprovedUserComments();
        return view('livewire.comments', compact('comments', 'comment_msg'));
    }

    protected function getUnapprovedUserComments($active = false)
    {
        $count = Comment::where('user_id', auth()->user()->id)
            ->where('is_active', $active)->where('post_id', '=', $this->post->id)->get()->count();
        return $count ? "Спасибо за оставленный комментарий! Он появится после модерации. <br> (модерация занимает до 2х суток)" : '';
    }

    protected function getCommentsByDate($order = 'desc')
    {
        return Comment::where('post_id', '=', $this->post->id)
            ->with(['post', 'user', 'comments'])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('created_at', $order)
            ->get();
    }
}
