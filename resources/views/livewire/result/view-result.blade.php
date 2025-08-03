<div>
    {{-- Page Heading --}}
    <header class="bg-white dark:bg-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                View Student Results
            </h2>
        </div>
    </header>

    <main class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Filter Section with Enhanced UI --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-lg p-4 sm:p-6 mb-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
                    <div>
                        <label for="exam" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Exam</label>
                        <select wire:model.live="selectedExam" id="exam" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Select Exam</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="baseClass" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Class</label>
                        <select wire:model.live="selectedBaseClass" id="baseClass" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Select Class</option>
                            @foreach($baseClasses as $class)
                                <option value="{{ $class->name }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="class" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Section / Group</label>
                        <select wire:model.live="selectedClass" id="class" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" @if(empty($selectedBaseClass)) disabled @endif>
                            <option value="">Select Section/Group</option>
                            @foreach($sectionsAndGroups as $class)
                                <option value="{{ $class->id }}">{{ $class->section ?? $class->group }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search Student</label>
                        <input wire:model.live.debounce.300ms="search" id="search" type="text" placeholder="By Name or Roll" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            {{-- Loading State --}}
            <div wire:loading.flex class="items-center justify-center py-10 text-gray-500 dark:text-gray-400">
                <svg class="animate-spin -ml-1 mr-3 h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span class="text-lg font-medium">Loading Results...</span>
            </div>

            <div wire:loading.remove>
                @if (!empty($students) && $students->count() > 0)
                    {{-- Result Summary with colorful design --}}
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-8">
                        <div class="bg-gradient-to-br from-blue-400 to-indigo-500 text-white p-4 rounded-xl shadow-lg flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium opacity-75">Total Students</p>
                                <p class="text-3xl font-bold">{{ $resultSummary['total_students'] ?? 0 }}</p>
                            </div>
                            <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="bg-gradient-to-br from-green-400 to-teal-500 text-white p-4 rounded-xl shadow-lg flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium opacity-75">Pass Rate</p>
                                <p class="text-3xl font-bold">{{ $resultSummary['pass_rate'] ?? 0 }}%</p>
                            </div>
                            <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="bg-gradient-to-br from-red-400 to-rose-500 text-white p-4 rounded-xl shadow-lg flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium opacity-75">Failed Students</p>
                                <p class="text-3xl font-bold">{{ $resultSummary['failed_students'] ?? 0 }}</p>
                            </div>
                             <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="bg-gradient-to-br from-yellow-400 to-orange-500 text-white p-4 rounded-xl shadow-lg flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium opacity-75">Highest Marks</p>
                                <p class="text-3xl font-bold">{{ $resultSummary['highest_marks'] ?? 0 }}</p>
                            </div>
                            <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-lg overflow-hidden">
                         <div class="flex flex-col sm:flex-row items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700 gap-4">
                             <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Student Results</h3>
                         </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800/50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Roll</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Marks</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">GPA</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Grade</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($students as $student)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $student->roll_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $student->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-semibold text-gray-800 dark:text-gray-200">{{ $results[$student->id]['total_marks'] ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold {{ $results[$student->id]['is_passed'] ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">{{ $results[$student->id]['gpa'] ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $results[$student->id]['is_passed'] ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                                                    {{ $results[$student->id]['grade'] ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ ($selectedExam && ($results[$student->id]['total_marks'] !== 'N/A')) ? route('marks.view-marksheet', ['student' => $student->id, 'exam' => $selectedExam]) : '#' }}" 
                                                   target="_blank" 
                                                   class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-semibold"
                                                   @if(!$selectedExam || ($results[$student->id]['total_marks'] === 'N/A')) onclick="event.preventDefault(); alert('Marksheet not available.');" @endif>View</a>
                                                
                                                <button wire:click="downloadSingleMarksheet({{ $student->id }})" 
                                                        class="ml-4 text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 font-semibold"
                                                        @if(($results[$student->id]['total_marks'] === 'N/A')) disabled @endif>Download</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @elseif($selectedExam && $selectedClass)
                    <div class="text-center py-10 bg-white dark:bg-gray-800 shadow-lg sm:rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">No Students Found</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">There are no students matching your search criteria in this class.</p>
                    </div>
                @else
                    <div class="text-center py-10 bg-white dark:bg-gray-800 shadow-lg sm:rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2z" /></svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">View Results</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Please select an exam, class, and section to begin.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>