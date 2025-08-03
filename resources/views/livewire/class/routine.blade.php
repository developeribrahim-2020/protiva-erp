<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Class Routine Management
        </h2>
    </x-slot>

    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Filter and Controls --}}
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6 mb-8">
                <div class.grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label for="selectedClassId" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Class to Manage/View</label>
                        <select wire:model.live="selectedClassId" id="selectedClassId" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Select a Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }} {{ $class->section ? '- '.$class->section : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                 @if (session()->has('message'))
                    <div class="mt-4 p-4 rounded-md bg-green-100 border border-green-300 text-green-700">
                        {{ session('message') }}
                    </div>
                @endif
            </div>

            @if ($selectedClassId)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Weekly Routine</h3>
                        <div class="overflow-x-auto mt-6">
                            <table class="min-w-full border border-gray-200 dark:border-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700/50">
                                    <tr>
                                        <th class="px-3 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase w-28">Time</th>
                                        @foreach($weekdays as $day)
                                            <th class="px-3 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">{{ ucfirst($day) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($classTimings as $timeSlot)
                                        @php
                                            list($startTime, $endTime) = explode(' - ', $timeSlot);
                                            $formattedStartTime = date('H:i:s', strtotime($startTime));
                                        @endphp
                                        <tr>
                                            <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-700/50">{{ date('h:i A', strtotime($startTime)) }}</td>
                                            @foreach($weekdays as $day)
                                                <td class="p-1 text-center align-middle">
                                                    @php
                                                        $routineEntry = $routines[$day][$formattedStartTime] ?? null;
                                                    @endphp
                                                    <button wire:click="openModal('{{ $day }}', '{{ $timeSlot }}')" class="w-full h-20 rounded-md flex flex-col items-center justify-center p-2 text-xs transition-colors duration-200 {{ $routineEntry ? 'bg-indigo-100 dark:bg-indigo-900/50 hover:bg-indigo-200 dark:hover:bg-indigo-900' : 'bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                                        @if($routineEntry)
                                                            <span class="font-bold text-indigo-800 dark:text-indigo-200">{{ $routineEntry->subject->name }}</span>
                                                            <span class="text-gray-600 dark:text-gray-400 mt-1">{{ $routineEntry->teacher->name }}</span>
                                                        @else
                                                            <span class="text-gray-400">+ Add</span>
                                                        @endif
                                                    </button>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-10 bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">Select a Class</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Please select a class from the dropdown menu to view or manage its routine.</p>
                </div>
            @endif

            <!-- Modal for Adding/Editing Routine -->
            @if($showModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md mx-4">
                        <form wire:submit.prevent="saveRoutine">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $modalData['routine_id'] ? 'Edit' : 'Add' }} Period for {{ ucfirst($modalData['weekday']) }} at {{ date('h:i A', strtotime($modalData['start_time'])) }}
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label for="modal_subject_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                                        <select wire:model="modalData.subject_id" id="modal_subject_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                            <option value="">Select Subject</option>
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('modalData.subject_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="modal_teacher_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teacher</label>
                                        <select wire:model="modalData.teacher_id" id="modal_teacher_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                            <option value="">Select Teacher</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('modalData.teacher_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-100 dark:bg-gray-900/50 px-6 py-4 flex justify-between items-center">
                                @if($modalData['routine_id'])
                                    <button type="button" onclick="confirm('Are you sure you want to delete this entry?') || event.stopImmediatePropagation()" wire:click="deleteRoutine" class="text-red-600 hover:text-red-800 text-sm font-medium">Delete Entry</button>
                                @else
                                    <div></div> {{-- To keep alignment --}}
                                @endif
                                <div class="flex gap-3">
                                    <button type="button" wire:click="closeModal" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm">Cancel</button>
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </main>
</div>