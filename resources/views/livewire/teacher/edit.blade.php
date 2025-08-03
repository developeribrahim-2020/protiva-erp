<div>
    {{-- Page Heading --}}
    <header class="bg-white dark:bg-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Teacher Information
            </h2>
        </div>
    </header>

    <main class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <form wire:submit.prevent="update" class="p-6 sm:p-8 space-y-8">
                    
                    {{-- Section 1: Personal Information --}}
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-3">
                            Personal Information
                        </h3>
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                                <input type="text" wire:model="name" id="name" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                @error('name') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <!-- Designation -->
                            <div>
                                <label for="designation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Designation</label>
                                <input type="text" wire:model="designation" id="designation" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                @error('designation') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                                <input type="tel" wire:model="phone" id="phone" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                @error('phone') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <!-- Qualification -->
                            <div>
                                <label for="qualification" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Qualification</label>
                                <input type="text" wire:model="qualification" id="qualification" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                @error('qualification') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>

                             <!-- Joining Date -->
                            <div>
                                <label for="joining_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Joining Date</label>
                                <input type="date" wire:model="joining_date" id="joining_date" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                @error('joining_date') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <!-- Address -->
                            <div class="sm:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                                <textarea wire:model="address" id="address" rows="3" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                                @error('address') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Login Credentials --}}
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-3">
                            Login Credentials
                        </h3>
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                             <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                                <input type="email" wire:model="email" id="email" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                @error('email') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                                <input type="password" wire:model="password" id="password" placeholder="Leave blank to keep unchanged" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                @error('password') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                    
                    {{-- Section 3: Photo Upload --}}
                     <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-3">
                            Profile Photo
                        </h3>
                        {{-- আপডেটেড নির্দেশনা --}}
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                            Please upload a square image (JPG, PNG). Maximum size: 1MB.
                        </p>
                        <div class="mt-4 flex items-center gap-6">
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" class="h-24 w-24 rounded-full object-cover">
                            @elseif($existing_image)
                                <img src="{{ asset('storage/' . $existing_image) }}" class="h-24 w-24 rounded-full object-cover">
                            @else
                                 <span class="inline-block h-24 w-24 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                  </span>
                            @endif
                            <input type="file" wire:model="image" id="image" class="block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100 dark:file:bg-indigo-900/50 dark:file:text-indigo-300 dark:hover:file:bg-indigo-900"/>
                        </div>
                        @error('image') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- Form Actions --}}
                    <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('teachers.index') }}" wire:navigate class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span wire:loading.remove wire:target="update">
                                Update Teacher
                            </span>
                            <span wire:loading wire:target="update">
                                Updating...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>