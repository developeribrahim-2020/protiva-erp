<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
    <form wire:submit.prevent="{{ $editingNoticeId ? 'updateItem' : 'createItem' }}" class="p-6 lg:p-8">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $editingNoticeId ? 'Edit' : 'Create New' }} Item</h3>
        
        @if (session()->has('message'))
            <div class="mt-4 p-4 rounded-md bg-green-100 border border-green-300 text-green-700">
                {{ session('message') }}
            </div>
        @endif

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                <select wire:model.live="type" id="type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                    <option value="notice">Notice</option>
                    <option value="event">Event</option>
                </select>
            </div>

            <div class="sm:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input type="text" wire:model="title" id="title" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content</label>
                <textarea wire:model="content" id="content" rows="5" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md"></textarea>
                @error('content') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            
            @if($type === 'event')
            <div>
                <label for="event_datetime" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Event Date & Time</label>
                <input type="datetime-local" wire:model="event_datetime" id="event_datetime" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                @error('event_datetime') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            @else
            <div>
                <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Publish Date</label>
                <input type="date" wire:model="published_at" id="published_at" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                @error('published_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            @endif

            <div>
                <label for="visibility" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Visible To</label>
                <select wire:model="visibility" id="visibility" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-