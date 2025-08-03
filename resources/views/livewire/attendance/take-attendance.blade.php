<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Take Attendance') }}
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

                    <div class="flex space-x-4 mb-4">
                        <div>
                            <x-input-label for="class" :value="__('Select Class')" />
                            <select wire:model="selectedClass" id="class" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">-- Choose Class --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="date" :value="__('Attendance Date')" />
                            <x-text-input wire:model="attendanceDate" id="date" class="block mt-1 w-full" type="date" />
                        </div>
                        <div class="self-end">
                            <x-primary-button wire:click="fetchStudents">
                                {{ __('Load Students') }}
                            </x-primary-button>
                        </div>
                    </div>
                    
                    @if (!empty($students))
                        <form wire:submit.prevent="saveAttendance">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Roll</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($students as $student)
                                            <tr wire:key="{{ $student->id }}">
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->roll_number }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center space-x-4">
                                                        <label class="inline-flex items-center">
                                                            <input type="radio" wire:model="statuses.{{ $student->id }}" value="present" class="form-radio text-green-600">
                                                            <span class="ml-2">Present</span>
                                                        </label>
                                                        <label class="inline-flex items-center">
                                                            <input type="radio" wire:model="statuses.{{ $student->id }}" value="absent" class="form-radio text-red-600">
                                                            <span class="ml-2">Absent</span>
                                                        </label>
                                                        <label class="inline-flex items-center">
                                                            <input type="radio" wire:model="statuses.{{ $student->id }}" value="late" class="form-radio text-yellow-600">
                                                            <span class="ml-2">Late</span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-6">
                                <x-primary-button>
                                    {{ __('Save Attendance') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>