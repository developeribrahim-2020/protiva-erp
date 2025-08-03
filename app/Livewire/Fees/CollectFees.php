<?php
namespace App\Livewire\Fees;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\FeeType;
use App\Models\Invoice;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class CollectFees extends Component
{
    public $selectedClassId, $selectedStudentId;
    public $students = [];
    public $invoices = [];
    public $fee_type_id, $amount, $due_date;

    public function updatedSelectedClassId($value)
    {
        $this->students = $value ? Student::where('school_class_id', $value)->orderBy('roll_number')->get() : [];
        $this->reset(['selectedStudentId', 'invoices']);
    }

    public function updatedSelectedStudentId($value)
    {
        $this->loadInvoices();
    }

    public function loadInvoices()
    {
        if ($this->selectedStudentId) {
            $this->invoices = Invoice::where('student_id', $this->selectedStudentId)
                ->with('feeType')
                ->latest()->get();
        }
    }

    public function createInvoice()
    {
        $this->validate([
            'selectedStudentId' => 'required',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        Invoice::create([
            'student_id' => $this->selectedStudentId,
            'fee_type_id' => $this->fee_type_id,
            'amount' => $this->amount,
            'due_amount' => $this->amount, // Initially, due amount is the full amount
            'due_date' => $this->due_date,
        ]);

        session()->flash('message', 'Invoice created successfully.');
        $this->loadInvoices();
        $this->reset(['fee_type_id', 'amount', 'due_date']);
    }
    
    public function collectPayment(Invoice $invoice, $paidAmount)
    {
        if ($paidAmount <= 0 || $paidAmount > $invoice->due_amount) {
            session()->flash('error', 'Invalid payment amount.');
            return;
        }

        // Create a transaction record
        Transaction::create([
            'invoice_id' => $invoice->id,
            'type' => 'income',
            'description' => "Fee collection from Roll: {$invoice->student->roll_number} for {$invoice->feeType->name}",
            'amount' => $paidAmount,
            'transaction_date' => now(),
        ]);

        // Update invoice
        $invoice->paid_amount += $paidAmount;
        $invoice->due_amount -= $paidAmount;
        $invoice->status = $invoice->due_amount == 0 ? 'paid' : 'partially_paid';
        $invoice->save();

        session()->flash('message', 'Payment collected successfully.');
        $this->loadInvoices();
    }

    public function render()
    {
        $classes = SchoolClass::orderBy('name')->get();
        $feeTypes = FeeType::orderBy('name')->get();

        return view('livewire.fees.collect-fees', [
            'classes' => $classes,
            'feeTypes' => $feeTypes,
        ]);
    }
}