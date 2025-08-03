<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Exam Routine Management
        </h2>
    </x-slot>

    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Section 1: View Routine --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">View Exam Routine</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Select an exam and class to view the routine.</p>
                    
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="viewExamId" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Exam</label>
                            <select wire:model.live="viewExamId" id="viewExamId" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Select Exam</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="viewClassId" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Class</label>
                            <select wire:model.live="viewClassId" id="viewClassId" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }} {{ $class->section ? '- '.$class->section : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="p-6 lg:p-8">
                    @if(!empty($routines) && $routines->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Subject</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Time</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Room No.</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($routines as $routine)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($routine->exam_date)->format('d M, Y (l)') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $routine->subject->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($routine->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($routine->end_time)->format('h:i A') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $routine->room_number ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif($viewExamId && $viewClassId)
                        <p class="text-center text-gray-500 dark:text-gray-400 py-6">No routine found for the selected criteria.</p>
                    @endif
                </div>
            </div>

            {{-- Section 2: Manage Routine (for Admins) --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <form wire:submit.prevent="{{ $editingRoutineId ? 'updateRoutine' : 'saveRoutine' }}" class="p-6 lg:p-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $editingRoutineId ? 'Edit Routine Entry' : 'Add New Routine Entry' }}</h3>
                    
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label for="exam_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Exam</label>
                            <select wire:model.live="exam_id" id="exam_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Select Exam</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                @endforeach
                            </select>
                            @error('exam_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="school_class_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Class</label>
                            <select wire:model.live="school_class_id" id="school_class_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }} {{ $class->section ? '- '.$class->section : '' }}</option>
                                @endforeach
                            </select>
                            @error('school_class_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="subject_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                            <select wire:model.live="subject_id" id="subject_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" @if(count($subjects) == 0) disabled @endif>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            @error('subject_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="exam_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                            <input type="date" wire:model="exam_date" id="exam_date" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                             @error('exam_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Time</label>
                            <input type="time" wire:model="start_time" id="start_time" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                             @error('start_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Time</label>
                            <input type="time" wire:model="end_time" id="end_time" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                             @error('end_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="sm:col-span-2 lg:col-span-3">
                             <label for="room_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Room Number</label>
                            <input type="text" wire:model="room_number" id="room_number" placeholder="e.g., Room 101" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            @error('room_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
                        @if($editingRoutineId)
                            <button type="button" wire:click="resetForm" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</button>
                        @endif
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ $editingRoutineId ? 'Update Entry' : 'Save Entry' }}
                        </button>
                    </div>

                    @if($viewExamId && $viewClassId)
                         <div class="mt-8">
                             <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Manage Entries for Selected Class</h3>
                            <ul class="mt-4 space-y-3">
                                @forelse($routines as $routine)
                                    <li class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $routine->subject->name }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($routine->exam_date)->format('d M, Y') }} | {{ \Carbon\Carbon::parse($routine->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($routine->end_time)->format('h:i A') }}</p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <button wire:click="editRoutine({{ $routine->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</button>
                                            <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteRoutine({{ $routine->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                        </div>
                                    </li>
                                @empty
                                    <p class="text-center text-gray-500 dark:text-gray-400 py-4">No entries to manage for this class.</p>
                                @endforelse
                            </ul>
                         </div>
                    @endif
                </form>
            </div>
        </div>
    </main>
</div>