<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Student;
use App\Models\SchoolClass;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('layouts.app')]
class Edit extends Component
{
    public Student $student;
    
    #[Rule('required|string|max:255')]
    public $name;

    #[Rule('required|integer')]
    public $roll_number;
    
    #[Rule('required|exists:school_classes,id')]
    public $school_class_id;

    public $classes;

    public function mount(Student $student): void
    {
        $this->student = $student;
        $this->name = $student->name;
        $this->roll_number = $student->roll_number;
        $this->school_class_id = $student->school_class_id;
        
        $this->classes = SchoolClass::orderBy('name')->orderBy('section')->get();
    }

    public function updateStudent(): void
    {
        $validated = $this->validate();
        
        // ডুপ্লিকেট রোল চেক করা হচ্ছে
        $existingStudent = Student::where('school_class_id', $this->school_class_id)
                                  ->where('roll_number', $this->roll_number)
                                  ->where('id', '!=', $this->student->id)
                                  ->first();

        if ($existingStudent) {
            $this->addError('roll_number', 'This roll number is already taken in the selected class.');
            return;
        }

        $this->student->update($validated);

        session()->flash('success', 'Student information updated successfully.');

        $this->redirectRoute('students.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.student.edit');
    }
}