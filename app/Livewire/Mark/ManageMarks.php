<?php
namespace App\Livewire\Mark;

use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Mark;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ManageMarks extends Component
{
    public $selectedExam = '';
    public $selectedBaseClass = ''; // e.g., 'Class Nine'
    public $selectedClass = ''; // This will hold the final class ID, e.g., the ID for 'Class Nine - Science'
    public $selectedSubject = '';
    
    public $sectionsAndGroups = [];
    public $subjects = [];
    public $students = [];
    public $marks = [];

    // This will run when the $selectedBaseClass property is updated.
    public function updatedSelectedBaseClass($value)
    {
        // Reset dependent dropdowns
        $this->sectionsAndGroups = SchoolClass::where('name', $value)->get();
        $this->selectedClass = '';
        $this->subjects = [];
        $this->students = [];
    }

    // This will run when the final $selectedClass ID is updated.
    public function updatedSelectedClass($value)
    {
        if ($value) {
            $class = SchoolClass::find($value);
            $this->subjects = $class ? $class->subjects()->get() : [];
        } else {
            $this->subjects = [];
        }
        $this->students = [];
    }

    public function fetchStudentsAndMarks()
    {
        $this->validate([
            'selectedExam' => 'required',
            'selectedClass' => 'required',
            'selectedSubject' => 'required',
        ]);
        
        $this->students = Student::where('school_class_id', $this->selectedClass)->orderBy('roll_number')->get();
        $existingMarks = Mark::where('exam_id', $this->selectedExam)
            ->where('subject_id', $this->selectedSubject)
            ->pluck('marks', 'student_id')->toArray();

        foreach ($this->students as $student) {
            $this->marks[$student->id] = $existingMarks[$student->id] ?? '';
        }
    }

    public function saveMarks()
    {
        $this->validate([
            'marks' => 'required|array',
            'marks.*' => 'nullable|integer|min:0|max:100',
        ]);

        foreach ($this->marks as $studentId => $mark) {
            Mark::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'exam_id' => $this->selectedExam,
                    'subject_id' => $this->selectedSubject,
                ],
                [
                    'school_class_id' => $this->selectedClass,
                    'marks' => $mark ?: null, // Save null if empty
                ]
            );
        }
        session()->flash('message', 'Marks saved successfully.');
    }

    public function render()
    {
        $exams = Exam::all();
        // Get unique base class names (e.g., Class One, Class Two)
        $baseClasses = SchoolClass::select('name')->distinct()->get();

        return view('livewire.mark.manage-marks', [
            'exams' => $exams,
            'baseClasses' => $baseClasses,
        ]);
    }
}