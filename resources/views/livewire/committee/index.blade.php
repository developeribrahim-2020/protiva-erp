<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Committee Members</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="flex justify-between items-center mb-6">
                        <a href="{{ route('administration.committees.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 border rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">Add New Member</a>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..." class="w-1/3 p-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Member Info</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                                @forelse ($committees as $member)
                                    <tr wire:key="{{ $member->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="h-12 w-12 flex-shrink-0">
                                                    <img class="h-12 w-12 rounded-full object-cover" src="{{ $member->image ? asset('storage/' . $member->image) : asset('default-avatar.png') }}" alt="">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $member->name }}</div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $member->designation }} ({{ $member->session_year }})</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 dark:text-gray-200">{{ $member->phone }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $member->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button wire:click="toggleStatus({{ $member->id }})" class="{{ $member->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-3 py-1 inline-flex text-xs font-semibold rounded-full">
                                                {{ $member->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            <button wire:click="printIdCard({{ $member->id }})" class="text-teal-600 hover:text-teal-900" title="Print ID Card">ID Card</button>
                                            <a href="{{ route('administration.committees.edit', $member->id) }}" wire:navigate class="text-indigo-600 hover:text-indigo-900 ml-4" title="Edit">Edit</a>
                                            <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteCommittee({{ $member->id }})" class="text-red-600 hover:text-red-900 ml-4" title="Delete">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-6 py-4 text-center">No committee members found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">{{ $committees->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>