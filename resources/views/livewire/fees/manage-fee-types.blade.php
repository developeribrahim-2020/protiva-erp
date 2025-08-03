<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Manage Fee Types
        </h2>
    </x-slot>

    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <form wire:submit.prevent="{{ $editingFeeTypeId ? 'updateFeeType' : 'saveFeeType' }}" class="p-6 lg:p-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $editingFeeTypeId ? 'Edit Fee Type' : 'Create New Fee Type' }}</h3>
                    
                    @if (session()->has('message'))
                        <div class="mt-4 p-4 rounded-md bg-green-100 border border-green-300 text-green-700">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fee Name</label>
                            <input type="text" wire:model="name" id="name" placeholder="e.g., Monthly Fee" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
                            <input type="number" step="0.01" wire:model="amount" id="amount" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                            @error('amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="school_class_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Specific Class (Optional)</label>
                            <select wire:model="school_class_id" id="school_class_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                                <option value="">For All Classes</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }} {{ $class->section }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        @if($editingFeeTypeId) <button type="button" wire:click="resetForm" class="px-4 py-2 text-sm font-medium bg-white border border-gray-300 rounded-md">Cancel</button> @endif
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Save</button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                 <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Existing Fee Types</h3>
                 <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50"><tr><th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Name</th><th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Amount</th><th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Class</th><th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th></tr></thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                            @forelse($feeTypes as $feeType)
                                <tr>
                                    <td class="px-6 py-4">{{ $feeType->name }}</td>
                                    <td class="px-6 py-4">{{ number_format($feeType->amount, 2) }}</td>
                                    <td class="px-6 py-4">{{ $feeType->schoolClass->name ?? 'All Classes' }}</td>
                                    <td class="px-6 py-4 text-right text-sm space-x-4">
                                        <button wire:click="editFeeType({{ $feeType->id }})" class="font-medium text-indigo-600 hover:text-indigo-900">Edit</button>
                                        <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteFeeType({{ $feeType->id }})" class="font-medium text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No fee types found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                 </div>
                 <div class="mt-4">{{ $feeTypes->links() }}</div>
            </div>
        </div>
    </main>
</div>