<?php
namespace App\Livewire\Fees;
use App\Models\FeeType;
use App\Models\SchoolClass;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ManageFeeTypes extends Component
{
    use WithPagination;

    public $name, $amount, $school_class_id;
    public $editingFeeTypeId = null;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'school_class_id' => 'nullable|exists:school_classes,id',
        ];
    }

    public function saveFeeType()
    {
        $this->validate();
        FeeType::create($this->only(['name', 'amount', 'school_class_id']));
        session()->flash('message', 'Fee Type created successfully.');
        $this->resetForm();
    }

    public function editFeeType(FeeType $feeType)
    {
        $this->editingFeeTypeId = $feeType->id;
        $this->name = $feeType->name;
        $this->amount = $feeType->amount;
        $this->school_class_id = $feeType->school_class_id;
    }

    public function updateFeeType()
    {
        $this->validate();
        $feeType = FeeType::findOrFail($this->editingFeeTypeId);
        $feeType->update($this->only(['name', 'amount', 'school_class_id']));
        session()->flash('message', 'Fee Type updated successfully.');
        $this->resetForm();
    }

    public function deleteFeeType(FeeType $feeType)
    {
        $feeType->delete();
        session()->flash('message', 'Fee Type deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset(['name', 'amount', 'school_class_id', 'editingFeeTypeId']);
    }

    public function render()
    {
        $feeTypes = FeeType::with('schoolClass')->latest()->paginate(10);
        $classes = SchoolClass::orderBy('name')->get();
        
        return view('livewire.fees.manage-fee-types', [
            'feeTypes' => $feeTypes,
            'classes' => $classes,
        ]);
    }
}