<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Committee Member') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form wire:submit.prevent="update">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="designation" :value="__('Designation')" />
                                <x-text-input wire:model="designation" id="designation" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('designation')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="phone" :value="__('Phone Number')" />
                                <x-text-input wire:model="phone" id="phone" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="session_year" :value="__('Session Year (e.g., 2024-2025)')" />
                                <x-text-input wire:model="session_year" id="session_year" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('session_year')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-6">
                            <x-primary-button>
                                {{ __('Update Member') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>