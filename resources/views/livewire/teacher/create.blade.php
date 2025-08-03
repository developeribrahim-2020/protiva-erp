<div>
    <header class="bg-white dark:bg-gray-800 shadow-sm"><div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Add New Teacher</h2></div></header>
    <main class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <form wire:submit.prevent="save" class="p-6 sm:p-8 space-y-8">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-3">Personal Information</h3>
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="sm:col-span-2"><label for="name" class="block text-sm font-medium">Full Name</label><input type="text" wire:model="name" id="name" class="mt-1 block w-full shadow-sm rounded-md">@error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror</div>
                            <div><label for="designation" class="block text-sm font-medium">Designation</label><input type="text" wire:model="designation" id="designation" class="mt-1 block w-full shadow-sm rounded-md">@error('designation') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror</div>
                            <div><label for="phone" class="block text-sm font-medium">Phone Number</label><input type="tel" wire:model="phone" id="phone" class="mt-1 block w-full shadow-sm rounded-md">@error('phone') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror</div>
                            <div><label for="qualification" class="block text-sm font-medium">Qualification</label><input type="text" wire:model="qualification" id="qualification" class="mt-1 block w-full shadow-sm rounded-md">@error('qualification') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror</div>
                            <div><label for="joining_date" class="block text-sm font-medium">Joining Date</label><input type="date" wire:model="joining_date" id="joining_date" class="mt-1 block w-full shadow-sm rounded-md">@error('joining_date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror</div>
                            <div class="sm:col-span-2"><label for="address" class="block text-sm font-medium">Address</label><textarea wire:model="address" id="address" rows="3" class="mt-1 block w-full shadow-sm rounded-md"></textarea>@error('address') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror</div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-3">Login Credentials</h3>
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div><label for="email" class="block text-sm font-medium">Email Address</label><input type="email" wire:model="email" id="email" class="mt-1 block w-full shadow-sm rounded-md">@error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror</div>
                            <div><label for="password" class="block text-sm font-medium">Password</label><input type="password" wire:model="password" id="password" class="mt-1 block w-full shadow-sm rounded-md">@error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror</div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-3">Profile Photo</h3>
                        <div class="mt-4"><input type="file" wire:model="image" id="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>@if ($image)<div class="mt-4"><img src="{{ $image->temporaryUrl() }}" class="mt-2 h-24 w-24 rounded-full object-cover"></div>@endif @error('image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror</div>
                    </div>
                    <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                        {{-- পরিবর্তন এখানে --}}
                        <a href="{{ route('academics.teachers.index') }}" wire:navigate class="px-4 py-2 text-sm font-medium bg-white border border-gray-300 rounded-md">Cancel</a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-6 border text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"><span wire:loading.remove>Save Teacher</span><span wire:loading>Saving...</span></button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>