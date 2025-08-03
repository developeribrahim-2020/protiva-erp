<?php
namespace App\Livewire\Accounts;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Transactions extends Component
{
    use WithPagination;

    // Form properties
    public $type = 'income';
    public $description;
    public $amount;
    public $transaction_date;
    public $payment_method = 'Cash';
    
    public $editingTransactionId = null;

    protected $rules = [
        'type' => 'required|in:income,expense',
        'description' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'transaction_date' => 'required|date',
        'payment_method' => 'required|string',
    ];

    public function saveTransaction()
    {
        $this->validate();
        Transaction::create($this->only(['type', 'description', 'amount', 'transaction_date', 'payment_method']));
        session()->flash('message', 'Transaction recorded successfully.');
        $this->resetForm();
    }

    public function editTransaction(Transaction $transaction)
    {
        $this->editingTransactionId = $transaction->id;
        $this->type = $transaction->type;
        $this->description = $transaction->description;
        $this->amount = $transaction->amount;
        $this->transaction_date = $transaction->transaction_date;
        $this->payment_method = $transaction->payment_method;
    }

    public function updateTransaction()
    {
        $this->validate();
        $transaction = Transaction::findOrFail($this->editingTransactionId);
        $transaction->update($this->only(['type', 'description', 'amount', 'transaction_date', 'payment_method']));
        session()->flash('message', 'Transaction updated successfully.');
        $this->resetForm();
    }

    public function deleteTransaction(Transaction $transaction)
    {
        // Note: Deleting a transaction from fee collection will not update the invoice.
        // This needs careful consideration based on school policy.
        $transaction->delete();
        session()->flash('message', 'Transaction deleted successfully.');
    }
    
    public function resetForm()
    {
        $this->reset(['type', 'description', 'amount', 'transaction_date', 'payment_method', 'editingTransactionId']);
    }

    public function render()
    {
        $transactions = Transaction::latest()->paginate(15);
        
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('livewire.accounts.transactions', [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
        ]);
    }
}