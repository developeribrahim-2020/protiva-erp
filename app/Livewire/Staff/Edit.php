<?php
namespace App\Livewire\Staff;
use App\Models\Staff;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]

class Edit extends Component
{
    public Staff $staff;
    public $name;
    public $designation;
    public $phone;
    public $email;
    public $address;
    public $joining_date;
    public function mount(Staff $staff)
    {
        $this->staff = $staff;
        $this->name = $staff->name;
        $this->designation = $staff->designation;
        $this->phone = $staff->phone;
        $this->email = $staff->email;
        $this->address = $staff->address;
        $this->joining_date = $staff->joining_date;
    }
    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:staff,phone,' . $this->staff->id,
            'email' => 'nullable|email|max:255|unique:staff,email,' . $this->staff->id,
            'address' => 'nullable|string',
            'joining_date' => 'nullable|date',
        ]);
        $this->staff->update($this->all());
        session()->flash('message', 'Staff member updated successfully.');
        return $this->redirect('/staff', navigate: true);
    }
    public function render()
    {
        return view('livewire.staff.edit');
    }
}