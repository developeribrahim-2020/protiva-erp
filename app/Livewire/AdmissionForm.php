<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\AdmissionApplication;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class AdmissionForm extends Component
{
    use WithFileUploads;

    public $student_name, $date_of_birth, $gender, $student_image;
    public $class_to_apply;
    public $father_name, $mother_name, $guardian_phone, $guardian_email;
    public $present_address, $permanent_address;
    
    public $applicationSubmitted = false;

    protected $rules = [
        'student_name' => 'required|string|max:255',
        'date_of_birth' => 'required|date',
        'gender' => 'required|string',
        'student_image' => 'nullable|image|max:1024',
        'class_to_apply' => 'required|string',
        'father_name' => 'required|string|max:255',
        'mother_name' => 'required|string|max:255',
        'guardian_phone' => 'required|string|max:20',
        'guardian_email' => 'nullable|email',
        'present_address' => 'required|string',
        'permanent_address' => 'required|string',
    ];

    public function submitApplication()
    {
        $validatedData = $this->validate();

        if ($this->student_image) {
            $validatedData['student_image'] = $this->student_image->store('admissions', 'public');
        }

        AdmissionApplication::create($validatedData);

        $this->applicationSubmitted = true;
    }

    public function render()
    {
        return view('livewire.admission-form');
    }
}