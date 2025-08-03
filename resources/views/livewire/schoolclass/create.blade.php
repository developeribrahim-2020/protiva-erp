<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Class') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form wire:submit.prevent="save">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="name" :value="__('Class Name (e.g., Play - Bely)')" />
                                <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="numeric_name" :value="__('Numeric Value (e.g., 1, 2)')" />
                                <x-text-input wire:model="numeric_name" id="numeric_name" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('numeric_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="section" :value="__('Section (if any)')" />
                                <x-text-input wire:model="section" id="section" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('section')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="group" :value="__('Group (if any)')" />
                                <x-text-input wire:model="group" id="group" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('group')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-6">
                            <x-primary-button>
                                {{ __('Save Class') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>