<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Notice & Event Board
        </h2>
    </x-slot>

    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if($showForm)
                @include('livewire.partials.notice-event-form')
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                        <div class="flex space-x-1 p-1 bg-gray-200 dark:bg-gray-700 rounded-lg">
                            <button wire:click="$set('filterType', 'all')" class="px-3 py-1 text-sm font-medium rounded-md {{ $filterType === 'all' ? 'bg-white dark:bg-gray-900 text-indigo-600' : 'text-gray-600 dark:text-gray-400' }}">All</button>
                            <button wire:click="$set('filterType', 'notice')" class="px-3 py-1 text-sm font-medium rounded-md {{ $filterType === 'notice' ? 'bg-white dark:bg-gray-900 text-indigo-600' : 'text-gray-600 dark:text-gray-400' }}">Notices</button>
                            <button wire:click="$set('filterType', 'event')" class="px-3 py-1 text-sm font-medium rounded-md {{ $filterType === 'event' ? 'bg-white dark:bg-gray-900 text-indigo-600' : 'text-gray-600 dark:text-gray-400' }}">Events</button>
                        </div>
                        <button wire:click="$set('showForm', true)" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Add New Item
                        </button>
                    </div>
                    
                    @if (session()->has('message') && !$showForm)
                        <div class="mb-4 p-4 rounded-md bg-green-100 border border-green-300 text-green-700">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="space-y-6">
                        @forelse ($items as $item)
                            <div wire:key="{{ $item->id }}" class="p-5 rounded-lg shadow-sm {{ $item->type === 'event' ? 'bg-blue-50 dark:bg-blue-900/50' : 'bg-gray-50 dark:bg-gray-700/50' }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->type === 'event' ? 'bg-blue-200 text-blue-800' : 'bg-gray-200 text-gray-800' }}">
                                            {{ ucfirst($item->type) }}
                                        </span>
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $item->title }}</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            @if($item->type === 'event')
                                                Event Date: <span class="font-semibold">{{ \Carbon\Carbon::parse($item->event_datetime)->format('d M, Y, h:i A') }}</span>
                                            @else
                                                Published on: <span class="font-semibold">{{ \Carbon\Carbon::parse($item->published_at)->format('d M, Y') }}</span>
                                            @endif
                                            | Visible to: <span class="font-semibold">{{ ucfirst($item->visibility) }}</span>
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-3 flex-shrink-0">
                                        <button wire:click="editItem({{ $item->id }})" class="text-indigo-600 hover:text-indigo-900"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                                        <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteItem({{ $item->id }})" class="text-red-600 hover:text-red-900"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    </div>
                                </div>
                                <div class="prose dark:prose-invert max-w-none mt-4 text-sm text-gray-600 dark:text-gray-300">
                                    {!! nl2br(e($item->content)) !!}
                                </div>
                                @if($item->attachment)
                                    <div class="mt-4">
                                        <a href="{{ asset('storage/' . $item->attachment) }}" target="_blank" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                            View Attachment
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-400 py-10">No items found for the selected filter.</p>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>