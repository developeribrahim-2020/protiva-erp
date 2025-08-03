<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Add New Committee Member</h2>
    </x-slot>

    <main class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <form wire:submit.prevent="save" class="p-6 sm:p-8 space-y-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                            <input type="text" wire:model="name" id="name" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="designation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Designation</label>
                            <input type="text" wire:model="designation" id="designation" placeholder="e.g., President, Member" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                            @error('designation') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="session_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Session Year</label>
                            <input type="text" wire:model="session_year" id="session_year" placeholder="e.g., 2024-2025" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                            @error('session_year') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                            <input type="tel" wire:model="phone" id="phone" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                            @error('phone') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email (Optional)</label>
                            <input type="email" wire:model="email" id="email" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                            <textarea wire:model="address" id="address" rows="3" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md"></textarea>
                        </div>
                         <div class="sm:col-span-2">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Photo</label>
                             <input type="file" wire:model="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                             @if ($image) <div class="mt-4"><img src="{{ $image->temporaryUrl() }}" class="h-24 w-24 rounded-full object-cover"></div> @endif
                             @error('image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('administration.committees.index') }}" wire:navigate class="px-4 py-2 text-sm font-medium bg-white border border-gray-300 rounded-md">Cancel</a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-6 border text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Save Member</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>