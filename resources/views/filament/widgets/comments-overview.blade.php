<x-filament::widget>
        <x-filament::card>
            <p class="text-lg font-bold">Комментарии ожидающие одобрения</p>
            @if(count($comments))
                @foreach($comments as $comment)
                    <div class="flex justify-between">
                        <div class="w-2/3 p-4">
                            <p>
                                <span class="font-semibold">CommentID:</span> {{$comment->id}}
                                <span class="font-semibold">PostID: </span> {{$comment->post_id}}
                                <span class="font-semibold">PostTitle: </span> <a  class="underline hover:text-blue-600" href="{{route('post.show', $comment->post)}}">{{$comment->post->title}}</a>
                            </p>
                            <p>
                                <span class="font-semibold">UserID: </span> {{$comment->user->id}}
                                <span class="font-semibold">UserName: </span>  {{$comment->user->name}}
                            </p>
                            <p class="admin_approve_comment"><span class="font-semibold">Comment: </span>{{$comment->comment}} </p>
                        </div>
                        <div class="flex flex-col py-4">
                            <a wire:click.prevent="deleteComment({{$comment->id}})" href="#" class="font-semibold text-red-600 text-sm">Delete</a>
                            <a wire:click.prevent="approveComment({{$comment->id}})" href="#" class="font-semibold text-green-600 text-sm">Approve</a>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Пока всё спокойно...</p>
            @endif
        </x-filament::card>
</x-filament::widget>
