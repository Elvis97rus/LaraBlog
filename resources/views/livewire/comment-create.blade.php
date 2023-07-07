<div class="my-2">
    <div x-data="{
            focused: {{ $parentComment ? 'true' : 'false' }},
            isEdit: {{ $commentModel ? 'true' : 'false' }},
            init() {
                if(this.isEdit || this.focused){
                    this.$refs.input.focus()
                }

                $wire.on('commentCreated', () => {
                    console.log('comment created..');
                    this.focused = false;
                })
            }
    }">
        <div class="mb-2">
            <textarea x-ref="input" wire:model="comment" @click="focused = true" placeholder="Leave some comment!" :rows="isEdit || focused ? '2' : '1'"
                      class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
        </div>
        <div :class="isEdit || focused ? '' : 'hidden'" >
            <button wire:click="createComment" type="submit" class="mr-3 rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Submit
            </button>
            <button @click="focused = false; isEdit = false; $wire.emitUp('cancelEditing')" type="submit" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Cancel
            </button>
        </div>

    </div>
</div>
