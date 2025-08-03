<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Income & Expense Transactions</h2>
    </x-slot>

    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-r from-green-400 to-teal-500 text-white p-6 rounded-lg shadow-lg">
                    <h4 class="text-sm font-medium uppercase">Total Income</h4>
                    <p class="text-3xl font-bold mt-2">{{ number_format($totalIncome, 2) }}</p>
                </div>
                <div class="bg-gradient-to-r from-red-400 to-rose-500 text-white p-6 rounded-lg shadow-lg">
                    <h4 class="text-sm font-medium uppercase">Total Expense</h4>
                    <p class="text-3xl font-bold mt-2">{{ number_format($totalExpense, 2) }}</p>
                </div>
                <div class="bg-gradient-to-r from-blue-400 to-indigo-500 text-white p-6 rounded-lg shadow-lg">
                    <h4 class="text-sm font-medium uppercase">Current Balance</h4>
                    <p class="text-3xl font-bold mt-2">{{ number_format($balance, 2) }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <form wire:submit.prevent="{{ $editingTransactionId ? 'updateTransaction' : 'saveTransaction' }}" class="p-6 lg:p-8">
                    <h3 class="text-xl font-semibold">{{ $editingTransactionId ? 'Edit Transaction' : 'Add New Transaction' }}</h3>
                    @if (session()->has('message')) <div class="mt-4 p-4 rounded-md bg-green-100 text-green-700">{{ session('message') }}</div> @endif

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label for="type" class="block text-sm font-medium">Type</label>
                            <select wire:model="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md">
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                        </div>
                        <div class="lg:col-span-2">
                            <label for="description" class="block text-sm font-medium">Description</label>
                            <input type="text" wire:model="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md">
                            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="amount" class="block text-sm font-medium">Amount</label>
                            <input type="number" step="0.01" wire:model="amount" id="amount" class="mt-1 block w-full border-gray-300 rounded-md">
                            @error('amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="transaction_date" class="block text-sm font-medium">Date</label>
                            <input type="date" wire:model="transaction_date" id="transaction_date" class="mt-1 block w-full border-gray-300 rounded-md">
                            @error('transaction_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="payment_method" class="block text-sm font-medium">Payment Method</label>
                             <input type="text" wire:model="payment_method" id="payment_method" class="mt-1 block w-full border-gray-300 rounded-md">
                            @error('payment_method') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        @if($editingTransactionId) <button type="button" wire:click="resetForm" class="px-4 py-2 bg-white border rounded-md">Cancel</button> @endif
                        <button type="submit" class="ml-3 py-2 px-4 border rounded-md text-white bg-indigo-600">{{ $editingTransactionId ? 'Update' : 'Save' }}</button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                 <h3 class="text-xl font-semibold">Transaction History</h3>
                 <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left">Date</th><th class="px-6 py-3 text-left">Description</th><th class="px-6 py-3 text-left">Type</th><th class="px-6 py-3 text-right">Amount</th><th class="px-6 py-3 text-right">Actions</th></tr></thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M, Y') }}</td>
                                    <td class="px-6 py-4">{{ $transaction->description }}</td>
                                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full {{ $transaction->type == 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ ucfirst($transaction->type) }}</span></td>
                                    <td class="px-6 py-4 text-right">{{ number_format($transaction->amount, 2) }}</td>
                                    <td class="px-6 py-4 text-right text-sm space-x-4">
                                        <button wire:click="editTransaction({{ $transaction->id }})" class="text-indigo-600">Edit</button>
                                        <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteTransaction({{ $transaction->id }})" class="text-red-600">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-6 py-4 text-center">No transactions found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                 </div>
                 <div class="mt-4">{{ $transactions->links() }}</div>
            </div>
        </div>
    </main>
</div>