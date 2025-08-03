<?php

namespace App\Livewire\Exam;

use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\ExamRoutine;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Routine extends Component
{
    // Form properties
    public $exam_id;
    public $school_class_id;
    public $subject_id;
    public $exam_date;
    public $start_time;
    public $end_time;
    public $room_number;

    public $editingRoutineId = null;

    // For viewing
    public $viewExamId;
    public $viewClassId;
    
    // Properties to hold data for dropdowns
    public $subjects = [];
    
    // Lazy loading routines when filters are set
    public function getRoutinesProperty()
    {
        if ($this->viewExamId && $this->viewClassId) {
            return ExamRoutine::with(['subject'])
                ->where('exam_id', $this->viewExamId)
                ->where('school_class_id', $this->viewClassId)
                ->orderBy('exam_date')
                ->orderBy('start_time')
                ->get();
        }
        return [];
    }

    public function updatedSchoolClassId($value)
    {
        if ($value) {
            $class = SchoolClass::with('subjects')->find($value);
            $this->subjects = $class ? $class->subjects()->orderBy('name')->get() : collect();
        } else {
            $this->subjects = collect();
        }
        $this->reset('subject_id');
    }

    protected function rules()
    {
        $rules = [
            'exam_id' => 'required|exists:exams,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'room_number' => 'nullable|string|max:255',
        ];

        $uniqueRule = 'unique:exam_routines,subject_id,' . ($this->editingRoutineId ?? 'NULL') . ',id';
        $uniqueRule .= ',exam_id,' . ($this->exam_id ?? 'NULL');
        $uniqueRule .= ',school_class_id,' . ($this->school_class_id ?? 'NULL');
        $rules['subject_id'] .= '|' . $uniqueRule;
        
        return $rules;
    }

    public function saveRoutine()
    {
        $this->validate();
        ExamRoutine::create($this->only(['exam_id', 'school_class_id', 'subject_id', 'exam_date', 'start_time', 'end_time', 'room_number']));
        session()->flash('message', 'Routine entry created successfully.');
        $this->resetForm();
    }

    public function editRoutine(ExamRoutine $routine)
    {
        $this->editingRoutineId = $routine->id;
        $this->exam_id = $routine->exam_id;
        $this->school_class_id = $routine->school_class_id;
        $this->updatedSchoolClassId($this->school_class_id);
        $this->subject_id = $routine->subject_id;
        $this->exam_date = $routine->exam_date;
        $this->start_time = $routine->start_time;
        $this->end_time = $routine->end_time;
        $this->room_number = $routine->room_number;
    }

    public function updateRoutine()
    {
        $this->validate();
        $routine = ExamRoutine::findOrFail($this->editingRoutineId);
        $routine->update($this->only(['exam_id', 'school_class_id', 'subject_id', 'exam_date', 'start_time', 'end_time', 'room_number']));
        session()->flash('message', 'Routine entry updated successfully.');
        $this->resetForm();
    }
    
    public function deleteRoutine(ExamRoutine $routine)
    {
        $routine->delete();
        session()->flash('message', 'Routine entry deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset(['exam_id', 'school_class_id', 'subject_id', 'exam_date', 'start_time', 'end_time', 'room_number', 'editingRoutineId']);
        $this->subjects = collect();
    }

    public function render()
    {
        $exams = Exam::orderBy('name')->get();
        $classes = SchoolClass::orderBy('name')->orderBy('section')->get();

        return view('livewire.exam.routine', [
            'exams' => $exams,
            'classes' => $classes,
        ]);
    }
}