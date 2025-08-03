<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Student Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form wire:submit.prevent="updateStudent">
                        
                        <!-- Student Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Student Name')" />
                            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Roll Number -->
                        <div class="mb-4">
                            <x-input-label for="roll_number" :value="__('Roll Number')" />
                            <x-text-input wire:model="roll_number" id="roll_number" class="block mt-1 w-full" type="number" required />
                            <x-input-error :messages="$errors->get('roll_number')" class="mt-2" />
                        </div>
                        
                        <!-- Class -->
                        <div class="mb-4">
                            <x-input-label for="school_class_id" :value="__('Class')" />
                            <select wire:model="school_class_id" id="school_class_id" class="block mt-1 w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Select Class --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">
                                        {{ $class->name }} - {{ $class->section ?? $class->group }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('school_class_id')" class="mt-2" />
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end mt-6">
                            {{-- পরিবর্তন এখানে --}}
                            <a href="{{ route('academics.students.index') }}" wire:navigate class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 mr-4">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Student') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>