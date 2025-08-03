<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Attendance Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="flex space-x-4 mb-4 items-end">
                        <div>
                            <x-input-label for="class" :value="__('Select Class')" />
                            <select wire:model="selectedClass" id="class" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">-- Choose Class --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="month" :value="__('Select Month')" />
                            <x-text-input wire:model="selectedMonth" id="month" class="block mt-1 w-full" type="month" />
                        </div>
                        <div>
                            <x-primary-button wire:click="generateReport">
                                {{ __('Generate Report') }}
                            </x-primary-button>
                        </div>
                        @if(!empty($students))
                        <div>
                            <x-secondary-button wire:click="downloadPdf">
                                {{ __('Download PDF') }}
                            </x-secondary-button>
                        </div>
                        @endif
                    </div>
                    
                    @if (!empty($students))
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-xs">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-2 py-2">Roll</th>
                                        <th class="px-2 py-2">Name</th>
                                        @foreach($daysInMonth as $day)
                                            <th class="px-2 py-2">{{ $day }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800">
                                    @foreach ($students as $student)
                                        <tr class="border-t dark:border-gray-700">
                                            <td class="px-2 py-2">{{ $student->roll_number }}</td>
                                            <td class="px-2 py-2 whitespace-nowrap">{{ $student->name }}</td>
                                            @foreach($daysInMonth as $day)
                                                <td class="px-2 py-2 text-center">
                                                    @php
                                                        $status = $attendances[$student->id][$day] ?? null;
                                                        $class = '';
                                                        $char = '';
                                                        if ($status === 'present') {
                                                            $class = 'text-green-500';
                                                            $char = 'P';
                                                        } elseif ($status === 'absent') {
                                                            $class = 'text-red-500';
                                                            $char = 'A';
                                                        } elseif ($status === 'late') {
                                                            $class = 'text-yellow-500';
                                                            $char = 'L';
                                                        }
                                                    @endphp
                                                    <span class="{{ $class }}">{{ $char }}</span>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>