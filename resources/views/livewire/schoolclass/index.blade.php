<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Classes List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="flex justify-between items-center mb-4">
                        <a href="{{ route('academics.classes.create') }}" wire:navigate class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Add New Class
                        </a>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search classes by name..." class="w-1/3 p-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Class Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Section / Group</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($schoolClasses as $class)
                                    <tr wire:key="{{ $class->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $class->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $class->section ?? $class->group }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('academics.classes.edit', $class->id) }}" wire:navigate class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-center">No classes found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $schoolClasses->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>