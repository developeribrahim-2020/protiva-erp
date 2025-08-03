<?php

namespace App\Livewire\Student;

use App\Models\SchoolClass;
use App\Models\Student;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Create extends Component
{
    // Form properties
    public $name;
    public $roll_number;
    public $school_class_id;
    public $father_name;
    public $mother_name;
    public $phone;
    public $address;

    // Options for dropdown
    public $classes;

    public function mount()
    {
        // Load all classes for the dropdown
        $this->classes = SchoolClass::all();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'roll_number' => 'required|integer',
            'school_class_id' => 'required|exists:school_classes,id',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Student::create([
            'name' => $this->name,
            'roll_number' => $this->roll_number,
            'school_class_id' => $this->school_class_id,
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        session()->flash('message', 'Student created successfully.');

        return $this->redirect('/students', navigate: true);
    }

    public function render()
    {
        return view('livewire.student.create');
    }
}