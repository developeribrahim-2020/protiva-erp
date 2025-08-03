<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Teachers List
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    
                    @if (session()->has('message'))
                        <div class="mb-4 p-4 rounded-md bg-green-100 border border-green-300 text-green-700">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                        <a href="{{ route('academics.teachers.create') }}" wire:navigate class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Add New Teacher
                        </a>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name, designation, or phone..." class="w-full sm:w-72 p-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm">
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teacher Info</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                                @forelse ($teachers as $teacher)
                                    <tr wire:key="{{ $teacher->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12">
                                                    @if ($teacher->image)
                                                        <img class="h-12 w-12 rounded-full object-cover" src="{{ asset('storage/' . $teacher->image) }}" alt="{{ $teacher->name }}">
                                                    @else
                                                        <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-gray-500"><span class="text-xl font-medium leading-none text-white">{{ strtoupper(substr($teacher->name, 0, 1)) }}</span></span>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $teacher->name }}</div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $teacher->designation }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-200">{{ $teacher->phone }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $teacher->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <button wire:click="toggleStatus({{ $teacher->id }})" class="{{ $teacher->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                                                {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="printIdCard({{ $teacher->id }})" class="text-teal-600 hover:text-teal-900">ID Card</button>
                                            <a href="{{ route('academics.teachers.edit', $teacher->id) }}" wire:navigate class="text-indigo-600 hover:text-indigo-900 ml-4">Edit</a>
                                            <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteTeacher({{ $teacher->id }})" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-6 py-4 text-center">No teachers found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $teachers->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>