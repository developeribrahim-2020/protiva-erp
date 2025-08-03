<?php
namespace App\Livewire\Attendance;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Attendance;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

#[Layout('layouts.app')]
class TakeAttendance extends Component
{
    public $selectedClass = '';
    public $attendanceDate;
    public $students = [];
    public $statuses = [];

    public function mount()
    {
        $this->attendanceDate = Carbon::today()->format('Y-m-d');
    }

    public function fetchStudents()
    {
        if ($this->selectedClass && $this->attendanceDate) {
            $this->students = Student::where('school_class_id', $this->selectedClass)->orderBy('roll_number')->get();
            
            $existingAttendance = Attendance::where('school_class_id', $this->selectedClass)
                                            ->where('attendance_date', $this->attendanceDate)
                                            ->pluck('status', 'student_id')
                                            ->toArray();

            foreach ($this->students as $student) {
                $this->statuses[$student->id] = $existingAttendance[$student->id] ?? 'absent';
            }
        } else {
            $this->students = [];
            $this->statuses = [];
        }
    }

    public function saveAttendance()
    {
        $this->validate([
            'selectedClass' => 'required',
            'attendanceDate' => 'required|date',
            'statuses' => 'required|array',
        ]);

        foreach ($this->statuses as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'attendance_date' => $this->attendanceDate,
                ],
                [
                    'school_class_id' => $this->selectedClass,
                    'status' => $status,
                ]
            );
        }

        session()->flash('message', 'Attendance saved successfully for ' . $this->attendanceDate);
        $this->fetchStudents(); // Re-fetch to show the saved state
    }

    public function render()
    {
        $classes = SchoolClass::all();
        return view('livewire.attendance.take-attendance', [
            'classes' => $classes,
        ]);
    }
}