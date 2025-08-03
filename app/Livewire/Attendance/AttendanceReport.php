<?php

namespace App\Livewire\Attendance;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Attendance;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

#[Layout('layouts.app')]
class AttendanceReport extends Component
{
    public $selectedClass = '';
    public $selectedMonth;
    public $students = [];
    public $attendances = [];
    public $daysInMonth = [];

    public function mount()
    {
        $this->selectedMonth = Carbon::now()->format('Y-m');
    }

    public function generateReport()
    {
        $this->validate([
            'selectedClass' => 'required',
            'selectedMonth' => 'required|date_format:Y-m',
        ]);

        $this->students = Student::where('school_class_id', $this->selectedClass)->orderBy('roll_number')->get();
        $attendancesData = Attendance::where('school_class_id', $this->selectedClass)
            ->whereYear('attendance_date', Carbon::parse($this->selectedMonth)->year)
            ->whereMonth('attendance_date', Carbon::parse($this->selectedMonth)->month)
            ->get();

        $this->attendances = [];
        foreach ($attendancesData as $attendance) {
            $this->attendances[$attendance->student_id][Carbon::parse($attendance->attendance_date)->day] = $attendance->status;
        }

        $date = Carbon::parse($this->selectedMonth);
        $this->daysInMonth = range(1, $date->daysInMonth);
    }

    public function downloadPdf()
    {
        $this->generateReport(); // Ensure data is loaded

        $data = [
            'students' => $this->students,
            'attendances' => $this->attendances,
            'daysInMonth' => $this->daysInMonth,
            'selectedMonth' => $this->selectedMonth,
            'className' => SchoolClass::find($this->selectedClass)->name,
        ];

        $pdf = Pdf::loadView('livewire.attendance.report-pdf', $data)->setPaper('a4', 'landscape');
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'attendance-report.pdf');
    }

    public function render()
    {
        $classes = SchoolClass::all();
        return view('livewire.attendance.attendance-report', [
            'classes' => $classes,
        ]);
    }
}