<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Collect Student Fees</h2>
    </x-slot>

    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <label for="selectedClassId" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Class</label>
                        <select wire:model.live="selectedClassId" id="selectedClassId" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                            <option value="">Select a Class</option>
                            @foreach($classes as $class) <option value="{{ $class->id }}">{{ $class->name }} {{ $class->section }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="selectedStudentId" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Student</label>
                        <select wire:model.live="selectedStudentId" id="selectedStudentId" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md" @if(!$students) disabled @endif>
                            <option value="">Select a Student</option>
                            @foreach($students as $student) <option value="{{ $student->id }}">Roll {{ $student->roll_number }} - {{ $student->name }}</option> @endforeach
                        </select>
                    </div>
                </div>

                @if($selectedStudentId)
                    <div>
                        <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Invoices for {{ $students->firstWhere('id', $selectedStudentId)->name }}</h3>
                        
                        {{-- Create Invoice Form --}}
                        <form wire:submit.prevent="createInvoice" class="mb-8 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                             <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
                                <div class="sm:col-span-2">
                                    <label for="fee_type_id" class="block text-sm font-medium">Fee Type</label>
                                    <select wire:model="fee_type_id" id="fee_type_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                                        <option>Select Fee</option>
                                        @foreach($feeTypes as $type) <option value="{{ $type->id }}">{{ $type->name }} ({{$type->amount}})</option> @endforeach
                                    </select>
                                </div>
                                <div><label for="amount" class="block text-sm font-medium">Amount</label><input type="number" wire:model="amount" id="amount" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md"></div>
                                <div><label for="due_date" class="block text-sm font-medium">Due Date</label><input type="date" wire:model="due_date" id="due_date" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md"></div>
                                <button type="submit" class="py-2 px-4 bg-blue-600 text-white rounded-md w-full">Create Invoice</button>
                            </div>
                        </form>

                        {{-- Invoices List --}}
                        <div class="space-y-4">
                            @forelse($invoices as $invoice)
                                <div class="p-4 border dark:border-gray-700 rounded-lg flex flex-col sm:flex-row justify-between items-center gap-4">
                                    <div>
                                        <p class="font-bold text-gray-800 dark:text-gray-200">{{ $invoice->feeType->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Amount: {{ $invoice->amount }} | Paid: {{ $invoice->paid_amount }} | <span class="font-semibold text-red-500">Due: {{ $invoice->due_amount }}</span></p>
                                    </div>
                                    @if($invoice->status !== 'paid')
                                        <div x-data="{ paidAmount: {{ $invoice->due_amount }} }" class="flex items-center gap-2">
                                            <input type="number" x-model="paidAmount" class="w-28 border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-md text-sm">
                                            <button @click="$wire.collectPayment({{ $invoice->id }}, paidAmount)" class="px-3 py-2 bg-green-600 text-white rounded-md text-xs font-semibold uppercase">Collect</button>
                                        </div>
                                    @else
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full dark:bg-green-800 dark:text-green-100">Paid in Full</span>
                                    @endif
                                </div>
                            @empty
                                <p class="text-center text-gray-500 dark:text-gray-400 py-6">No invoices found for this student.</p>
                            @endforelse
                        </div>
                    </div>
                @else
                    <div class="text-center py-10">
                        <p class="text-gray-500 dark:text-gray-400">Please select a class and student to view invoices.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>