<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            School Settings
        </h2>
    </x-slot>

    <main class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <form wire:submit.prevent="saveSettings" class="p-6 lg:p-8">
                    @if (session()->has('message'))
                        <div class="mb-6 p-4 rounded-md bg-green-100 border border-green-300 text-green-700">
                            {{ session('message') }}
                        </div>
                    @endif
                
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label for="school_name" class="block text-sm font-medium">School Name</label>
                            <input type="text" wire:model="school_name" id="school_name" class="mt-1 block w-full shadow-sm rounded-md">
                            @error('school_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="eiin" class="block text-sm font-medium">EIIN</label>
                            <input type="text" wire:model="eiin" id="eiin" class="mt-1 block w-full shadow-sm rounded-md">
                            @error('eiin') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium">Phone Number</label>
                            <input type="tel" wire:model="phone" id="phone" class="mt-1 block w-full shadow-sm rounded-md">
                            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-medium">Email Address</label>
                            <input type="email" wire:model="email" id="email" class="mt-1 block w-full shadow-sm rounded-md">
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="block text-sm font-medium">Address</label>
                            <textarea wire:model="address" id="address" rows="3" class="mt-1 block w-full shadow-sm rounded-md"></textarea>
                            @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="logo" class="block text-sm font-medium">School Logo</label>
                            <div class="mt-2 flex items-center gap-6">
                                @if ($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" class="h-20 w-20 object-contain">
                                @elseif($existing_logo)
                                    <img src="{{ asset('storage/' . $existing_logo) }}" class="h-20 w-20 object-contain">
                                @endif
                                <input type="file" wire:model="logo" id="logo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            </div>
                            @error('logo') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 border-t mt-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-6 border text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>