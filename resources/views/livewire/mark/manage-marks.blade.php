<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Marks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session()->has('message'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-300" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <!-- Select Exam -->
                        <div>
                            <x-input-label for="exam" :value="__('Select Exam')" />
                            <select wire:model.live="selectedExam" id="exam" class="mt-1 block w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">-- Choose Exam --</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Select Base Class -->
                        <div>
                            <x-input-label for="base_class" :value="__('Select Class')" />
                            <select wire:model.live="selectedBaseClass" id="base_class" class="mt-1 block w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">-- Choose Class --</option>
                                @foreach($baseClasses as $baseClass)
                                    <option value="{{ $baseClass->name }}">{{ $baseClass->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Select Section/Group -->
                        <div>
                            <x-input-label for="class" :value="__('Select Section / Group')" />
                            <select wire:model.live="selectedClass" id="class" class="mt-1 block w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" @if(empty($selectedBaseClass)) disabled @endif>
                                <option value="">-- Choose Section/Group --</option>
                                @foreach($sectionsAndGroups as $class)
                                    <option value="{{ $class->id }}">{{ $class->section ?? $class->group }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Select Subject -->
                        <div>
                            <x-input-label for="subject" :value="__('Select Subject')" />
                            <select wire:model.live="selectedSubject" id="subject" class="mt-1 block w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" @if(empty($selectedClass)) disabled @endif>
                                <option value="">-- Choose Subject --</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mb-4">
                        <x-primary-button wire:click="fetchStudentsAndMarks">
                            {{ __('Load Students') }}
                        </x-primary-button>
                    </div>
                    
                    @if (!empty($students))
                        <form wire:submit.prevent="saveMarks">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left">Roll</th>
                                            <th class="px-6 py-3 text-left">Name</th>
                                            <th class="px-6 py-3 text-left">Marks (out of 100)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($students as $student)
                                            <tr wire:key="{{ $student->id }}">
                                                <td class="px-6 py-4">{{ $student->roll_number }}</td>
                                                <td class="px-6 py-4">{{ $student->name }}</td>
                                                <td class="px-6 py-4">
                                                    <x-text-input type="number" wire:model="marks.{{ $student->id }}" class="w-24" max="100" min="0" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-6">
                                <x-primary-button>
                                    {{ __('Save Marks') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>