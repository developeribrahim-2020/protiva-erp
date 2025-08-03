<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Subject') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form wire:submit.prevent="save">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="name" :value="__('Subject Name')" />
                                <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="subject_code" :value="__('Subject Code')" />
                                <x-text-input wire:model="subject_code" id="subject_code" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('subject_code')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="type" :value="__('Type (e.g., Core, Optional)')" />
                                <x-text-input wire:model="type" id="type" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-6">
                            <x-primary-button>
                                {{ __('Save Subject') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>