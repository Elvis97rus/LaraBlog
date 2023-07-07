<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;

class CommentCreate extends Component
{
    public string $comment = '';
    public Post $post;
    public ?Comment $commentModel;
    public ?Comment $parentComment;

    public function mount(Post $post, $commentModel = null, $parentComment = null)
    {
        $this->post = $post;
        $this->commentModel = $commentModel;
        $this->comment = $commentModel ? $commentModel->comment : '';
        $this->parentComment = $parentComment;

    }

    public function render()
    {
        return view('livewire.comment-create');
    }

    public function createComment()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->redirectToRoute('login');
        }
//        dd($this, $this->commentModel);
        if (isset($this->commentModel) && $this->commentModel) {
            if ($this->commentModel->user_id != $user->id) {
                return response('You are not allowed to perform this action',403);
            }
            $this->commentModel->comment = $this->comment;
            $this->commentModel->save();

            $this->comment = '';
            $this->emitUp('commentUpdated');
        } else {
            $comment = Comment::create([
                'comment' => $this->comment,
                'post_id' => $this->post->id,
                'user_id' => $user->id,
                'parent_id' => $this->parentComment?->id,
                'is_active' => 1 // TODO сделать секцию в админке для апрувов коментариев, а сохранять изначально не активные
            ]);

            $this->emitUp('commentCreated', $comment->id);

            $this->comment = '';
        }
    }
}
