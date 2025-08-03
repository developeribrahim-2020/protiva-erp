<div>
    {{-- Page Heading --}}
    <header class="bg-white dark:bg-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Bulk Marks Entry
            </h2>
        </div>
    </header>

    <main class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4 sm:p-6 lg:p-8">
                    
                    {{-- Session Message --}}
                    @if (session()->has('message'))
                        <div class="mb-6 p-4 rounded-md {{ $errorCount > 0 ? 'bg-yellow-50 dark:bg-yellow-900/50 border border-yellow-300 dark:border-yellow-600' : 'bg-green-50 dark:bg-green-900/50 border border-green-300 dark:border-green-600' }}">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    @if($errorCount > 0)
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 15a1 1 0 110-2 1 1 0 010 2zm-1-4a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    @else
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    </svg>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium {{ $errorCount > 0 ? 'text-yellow-800 dark:text-yellow-200' : 'text-green-800 dark:text-green-200' }}">{{ $errorCount > 0 ? 'Process Completed with Errors' : 'Process Completed Successfully' }}</h3>
                                    <div class="mt-2 text-sm {{ $errorCount > 0 ? 'text-yellow-700 dark:text-yellow-300' : 'text-green-700 dark:text-green-300' }}">
                                        <p>{{ session('message') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form wire:submit.prevent="processMarks" class="space-y-6">
                        
                        {{-- Exam Selection --}}
                        <div>
                            <label for="selectedExam" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Exam</label>
                            <select wire:model.live="selectedExam" id="selectedExam" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">-- Please select an exam --</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                @endforeach
                            </select>
                            @error('selectedExam') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>

                        {{-- Text Data Input --}}
                        <div>
                            <label for="textData" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Paste Marks Data</label>
                            <div class="mt-1 p-3 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-md">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Provide data in CSV format, one entry per line:</p>
                                <code class="text-xs text-red-600 dark:text-red-400 break-words">ClassName-Section,Roll,SubjectName,Marks</code>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Example: <code class="text-xs">Play-A,1,English,99</code></p>
                            </div>
                            <textarea wire:model="textData" id="textData" rows="15" 
                                      class="mt-2 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" 
                                      placeholder="Paste your data here..."></textarea>
                            @error('textData') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                        
                        {{-- Submit Button --}}
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex w-full sm:w-auto items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200" 
                                    wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="processMarks">
                                    <svg class="h-5 w-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M15.964 2.376a.75.75 0 01.428 1.34l-9.393 4.696a.75.75 0 01-.856 0l-3.857-1.928A.75.75 0 012.25 6V4.75a.75.75 0 01.75-.75h12.188a.75.75 0 01.776.376zM4.5 10.25a.75.75 0 01.75-.75h10a.75.75 0 010 1.5H5.25a.75.75 0 01-.75-.75zM4.5 13.25a.75.75 0 01.75-.75h10a.75.75 0 010 1.5H5.25a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                                    </svg>
                                    Process Marks
                                </span>
                                <span wire:loading wire:target="processMarks">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Processing...
                                </span>
                            </button>
                        </div>
                    </form>

                    {{-- Displaying Errors After Processing --}}
                    @if (!empty($processingErrors))
                        <div class="mt-8">
                             <div class="border-l-4 border-red-400 bg-red-50 dark:bg-red-900/50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-red-800 dark:text-red-200">Found {{ $errorCount }} errors during processing:</p>
                                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                            <ul role="list" class="list-disc space-y-1 pl-5" style="max-height: 300px; overflow-y: auto;">
                                                @foreach($processingErrors as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </main>
</div>