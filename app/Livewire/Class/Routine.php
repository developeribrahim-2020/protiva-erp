<?php

namespace App\Livewire\Class;

use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\ClassRoutine;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Routine extends Component
{
    public $selectedClassId;
    public $weekdays = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
    public $classTimings = [ // আপনি আপনার স্কুলের সময় অনুযায়ী এটি পরিবর্তন করতে পারেন
        '09:00 - 09:45',
        '09:45 - 10:30',
        '10:30 - 11:15',
        '11:15 - 12:00',
        '12:00 - 12:45',
        '01:30 - 02:15',
        '02:15 - 03:00',
    ];

    public $routines = [];
    public $subjects = [];
    public $teachers = [];

    // Modal properties
    public $showModal = false;
    public $modalData = [
        'weekday' => '',
        'start_time' => '',
        'end_time' => '',
        'subject_id' => '',
        'teacher_id' => '',
    ];

    public function updatedSelectedClassId($classId)
    {
        $this->selectedClassId = $classId;
        if ($classId) {
            $class = SchoolClass::with('subjects')->find($classId);
            $this->subjects = $class ? $class->subjects()->orderBy('name')->get() : collect();
            $this->loadRoutines();
        } else {
            $this->subjects = collect();
            $this->routines = [];
        }
    }

    public function loadRoutines()
    {
        $this->routines = ClassRoutine::where('school_class_id', $this->selectedClassId)
            ->with(['subject', 'teacher'])
            ->get()
            ->groupBy('weekday')
            ->map(function ($dayRoutines) {
                return $dayRoutines->keyBy('start_time');
            });
    }

    public function openModal($weekday, $timeSlot)
    {
        list($startTime, $endTime) = explode(' - ', $timeSlot);
        $startTime = date('H:i:s', strtotime($startTime));

        $existingRoutine = $this->routines[$weekday][$startTime] ?? null;

        $this->modalData = [
            'weekday' => $weekday,
            'start_time' => date('H:i', strtotime($startTime)),
            'end_time' => date('H:i', strtotime($endTime)),
            'subject_id' => $existingRoutine->subject_id ?? '',
            'teacher_id' => $existingRoutine->teacher_id ?? '',
            'routine_id' => $existingRoutine->id ?? null,
        ];
        
        $this->showModal = true;
    }

    public function saveRoutine()
    {
        $this->validate([
            'modalData.subject_id' => 'required|exists:subjects,id',
            'modalData.teacher_id' => 'required|exists:teachers,id',
        ]);
        
        ClassRoutine::updateOrCreate(
            [
                'school_class_id' => $this->selectedClassId,
                'weekday' => $this->modalData['weekday'],
                'start_time' => $this->modalData['start_time'],
            ],
            [
                'end_time' => $this->modalData['end_time'],
                'subject_id' => $this->modalData['subject_id'],
                'teacher_id' => $this->modalData['teacher_id'],
            ]
        );

        session()->flash('message', 'Routine updated successfully.');
        $this->closeModal();
        $this->loadRoutines();
    }

    public function deleteRoutine()
    {
        if(isset($this->modalData['routine_id'])) {
            ClassRoutine::destroy($this->modalData['routine_id']);
            session()->flash('message', 'Routine entry deleted successfully.');
        }
        $this->closeModal();
        $this->loadRoutines();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset('modalData');
    }

    public function render()
    {
        $classes = SchoolClass::orderBy('name')->orderBy('section')->get();
        $this->teachers = Teacher::where('is_active', true)->orderBy('name')->get();

        return view('livewire.class.routine', [
            'classes' => $classes,
        ]);
    }
}