<div class="my-4">

    <livewire:comment-create :post="$post" />
    @if($comments->count())
        <p class="px-4 py-2">Comments</p>

        @foreach($comments as $comment)
            <livewire:comment-item :comment="$comment" wire:key="comment-{{$comment->id}}-{{$comment->comments->count()}}" />
        @endforeach
    @endif
</div>
