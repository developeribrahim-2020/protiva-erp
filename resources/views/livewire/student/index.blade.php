<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-800/50 border-l-4 border-green-500 text-green-700 dark:text-green-200 rounded-r-lg" role="alert">
                            <p class="font-bold">Success</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <!-- Control Panel -->
                    <div class="mb-6 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                            <div class="flex items-center gap-2 flex-wrap">
                                <a href="{{ route('academics.students.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-blue-600 border rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i> Add New
                                </a>
                                <a href="{{ route('academics.students.bulk-entry') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-purple-600 border rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700">
                                    <i class="fas fa-file-import mr-2"></i> Bulk Entry
                                </a>
                                <button onclick="printTable()" class="inline-flex items-center px-4 py-2 bg-gray-600 border rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    <i class="fas fa-print mr-2"></i> Print List
                                </button>
                            </div>
                            <div class="w-full md:w-auto md:min-w-64">
                                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by name or roll..." class="w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                            <select wire:model.live="selectedBaseClass" class="form-select block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                <option value="">-- All Classes --</option>
                                @foreach($baseClasses as $class)
                                    <option value="{{ $class->name }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            <select wire:model.live="selectedClass" class="form-select block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700" @if(empty($sectionsAndGroups)) disabled @endif>
                                <option value="">-- All Sections / Groups --</option>
                                @foreach($sectionsAndGroups as $class)
                                    <option value="{{ $class->id }}">{{ $class->section ?? $class->group }}</option>
                                @endforeach
                            </select>
                            <select wire:model.live="perPage" class="form-select block w-full dark:bg-gray-900 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                <option value="10">10 per page</option>
                                <option value="25">25 per page</option>
                                <option value="50">50 per page</option>
                                <option value="100">100 per page</option>
                            </select>
                        </div>
                    </div>

                    <!-- Students Table -->
                    <div class="overflow-x-auto" id="students-table-container">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Roll</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Section/Group</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase print-hide">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                                @forelse ($students as $student)
                                    <tr wire:key="{{ $student->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->roll_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->schoolClass->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->schoolClass->section ?? $student->schoolClass->group }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium print-hide">
                                            {{-- আইডি কার্ড বাটন যোগ করা হয়েছে --}}
                                            <button wire:click="printIdCard({{ $student->id }})" class="font-medium text-teal-600 hover:text-teal-900 dark:text-teal-400 dark:hover:text-teal-300" title="Print ID Card">
                                                ID Card
                                            </button>
                                            <a href="{{ route('academics.students.edit', $student) }}" wire:navigate class="ml-4 font-medium text-indigo-600 hover:text-indigo-900">
                                                Edit
                                            </a>
                                            <button 
                                                wire:click="deleteStudent({{ $student->id }})" 
                                                wire:confirm="Are you sure you want to delete this student?"
                                                class="ml-4 font-medium text-red-600 hover:text-red-900">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No students found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 print-hide">{{ $students->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printTable() {
            // ... আপনার প্রিন্ট স্ক্রিপ্ট এখানে থাকবে ...
        }
    </script>
</div>