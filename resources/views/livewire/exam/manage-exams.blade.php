<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Manage Exams
        </h2>
    </x-slot>

    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <form wire:submit.prevent="{{ $editingExamId ? 'updateExam' : 'saveExam' }}" class="p-6 lg:p-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $editingExamId ? 'Edit Exam' : 'Create New Exam' }}</h3>
                    
                    @if (session()->has('message'))
                        <div class="mt-4 p-4 rounded-md bg-green-100 border border-green-300 text-green-700">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="mt-6 flex flex-col sm:flex-row items-start sm:items-end gap-4">
                        <div class="w-full">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Exam Name</label>
                            <input type="text" wire:model="name" id="name" placeholder="e.g., Final Examination 2025" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex-shrink-0 flex gap-2 w-full sm:w-auto">
                            @if($editingExamId)
                                <button type="button" wire:click="cancelEdit" class="w-full justify-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm">Cancel</button>
                            @endif
                            <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                {{ $editingExamId ? 'Update Exam' : 'Save Exam' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                 <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Existing Exams</h3>
                 <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Exam Name</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                            </tr>
                        </thead>
                         <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($exams as $exam)
                                <tr wire:key="{{ $exam->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $exam->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                                        <button wire:click="editExam({{ $exam->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</button>
                                        <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteExam({{ $exam->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-center text-gray-500">No exams found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                 </div>
                 <div class="mt-4">{{ $exams->links() }}</div>
            </div>
        </div>
    </main>
</div>