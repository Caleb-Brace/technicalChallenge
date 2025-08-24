<div class="max-w-3xl mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Tasks</h1>
        <button wire:click="create" class="bg-cyan-500 border-2 border-lime-500 text-white px-3 py-1.5 rounded-md shadow hover:bg-cyan-700">+ New Task</button>
        <button wire:click="filterTasks" class="bg-cyan-500 border-2 border-lime-500 text-white px-3 py-1.5 rounded-md shadow hover:bg-indigo-700">
            @if($filter === 'all')

                Filter: Completed
            @elseif($filter === 'completed')

                Filter: Uncompleted
            @else 

                Filter: None
            @endif
        </button>
        
    </div>


    <div class="space-y-2">
        @foreach($tasks as $task)
        <div class="rounded-lg border p-3 flex justify-between items-center @if($task->completed) bg-green-50 @endif">
            <div>
                <h2 class="font-medium {{ $task->completed ? 'line-through text-gray-500' : '' }}">{{ $task->title }}</h2>
                <p class="text-sm text-gray-600">Due: {{ $task->due_date->format('M j, Y') }}</p>
                @if($task->description)
                <p class="text-sm text-gray-500">{{ $task->description }}</p>
                @endif
            </div>
            <div class="flex gap-2">
                <button wire:click="toggleComplete({{ $task->id }})" class="px-2 py-1 text-xs rounded border {{ $task->completed ? 'bg-green-600 text-white' : 'bg-gray-100' }}">
                {{ $task->completed ? 'Completed' : 'Mark Done' }}
                </button>
                <button wire:click="edit({{ $task->id }})" class="px-2 py-1 text-xs underline">Edit</button>
                <button wire:click="deleteEntry({{ $task->id }})" class="px-2 py-1 text-xs text-red-600 underline" onclick="return confirm('Delete this task?')">Delete</button>
            </div>
        </div>
        @endforeach
    </div>


    {{-- Modal --}}
    @if($display)
        <div class="fixed inset-0 bg-black/40 z-40" wire:click="display=false"></div>
        <div class="fixed inset-0 z-50 grid place-items-center p-4">
            <div class="bg-white rounded-lg shadow-xl p-4 w-full max-w-md">
                <h2 class="text-lg font-semibold mb-3">{{ $taskID ? 'Edit Task' : 'New Task' }}</h2>


                <div class="space-y-3">
                    <label class="block">
                        <span class="text-sm">Title</span>
                        <input type="text" wire:model.defer="title" class="w-full rounded-md border px-3 py-2" />
                        @error('title')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>

                    <label class="block">
                        <span class="text-sm">Description</span>
                        <textarea wire:model.defer="description" class="w-full rounded-md border px-3 py-2" rows="3"></textarea>
                    </label>


                    <label class="block">
                    <span class="text-sm">Due Date</span>
                    <input type="date" wire:model.defer="due_date" min="{{date('Y-m-d')}}" class="w-full rounded-md border px-3 py-2" />
                    @error('due_date')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>


                    <label class="inline-flex items-center gap-2">
                    <input type="checkbox" wire:model.defer="completed" />
                    <span class="text-sm">Completed</span>
                    </label>
                </div>


                <div class="mt-4 flex justify-end gap-2">
                    <button wire:click="$set('display',false)" class="rounded-md border px-3 py-1.5">Cancel</button>
                    <button wire:click="save" class="bg-cyan-500 border-2 border-lime-500 text-white px-3 py-1.5">Save</button>
                </div>
            </div>
        </div>
    @endif
</div>
