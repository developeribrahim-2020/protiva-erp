<?php

namespace App\Livewire\Result;

use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Mark;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Helpers\ResultHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.app')]

class ViewResult extends Component
{
    public $selectedExam = '';
    public $selectedBaseClass = '';
    public $selectedClass = '';
    public $search = '';
    
    public $sectionsAndGroups = [];
    public $students = [];
    public $results = [];
    public $resultSummary = [];

    public function updatedSelectedBaseClass($value)
    {
        if ($value) {
            $this->sectionsAndGroups = SchoolClass::where('name', $value)->orderBy('section')->orderBy('group')->get();
        } else {
            $this->sectionsAndGroups = [];
        }
        $this->reset(['selectedClass', 'students', 'results', 'search', 'resultSummary']);
    }
    
    public function updatedSelectedClass() { $this->generateResult(); }
    public function updatedSelectedExam() { $this->generateResult(); }
    public function updatedSearch() { $this->generateResult(); }
    
    public function generateResult()
    {
        if (!$this->selectedExam || !$this->selectedClass) {
            $this->students = [];
            $this->results = [];
            $this->resultSummary = [];
            return;
        }

        $this->students = Student::where('school_class_id', $this->selectedClass)
                                ->where(function ($query) {
                                    $query->where('name', 'like', '%'.$this->search.'%')
                                          ->orWhere('roll_number', 'like', '%'.$this->search.'%');
                                })
                                ->orderBy('roll_number', 'asc')
                                ->get();
        
        $studentIds = $this->students->pluck('id');

        $allMarks = Mark::where('exam_id', $this->selectedExam)
                        ->whereIn('student_id', $studentIds)
                        ->with('subject')
                        ->get()
                        ->groupBy('student_id');

        $this->results = [];
        $totalStudents = $this->students->count();
        $passedStudents = 0;
        $highestMarks = 0;

        foreach ($this->students as $student) {
            $studentMarks = $allMarks->get($student->id);

            if (is_null($studentMarks) || $studentMarks->isEmpty()) {
                $this->results[$student->id] = ['total_marks' => 'N/A', 'gpa' => 'N/A', 'grade' => 'N/A', 'is_passed' => false];
                continue;
            }

            $totalMarks = 0;
            $mandatoryGradePoints = [];
            $optionalSubjectGradePoint = null;
            $mandatorySubjectCount = 0;
            $optionalSubjectName = 'H.math'; // <-- ঐচ্ছিক বিষয়ের নাম

            foreach ($studentMarks as $mark) {
                $totalMarks += $mark->marks;
                $gradeInfo = ResultHelper::calculateGrade($mark->marks);
                
                if (strcasecmp($mark->subject->name, $optionalSubjectName) == 0) {
                    $optionalSubjectGradePoint = (float)$gradeInfo->grade_point;
                } else {
                    $mandatoryGradePoints[] = (float)$gradeInfo->grade_point;
                    $mandatorySubjectCount++;
                }
            }
            
            // --- যে লাইনটি ঠিক করা হয়েছে ---
            $gpaResult = ResultHelper::calculateGpa($mandatoryGradePoints, $optionalSubjectGradePoint, $mandatorySubjectCount);
            
            $isPassed = ($gpaResult->grade !== 'F');

            $this->results[$student->id] = [
                'total_marks' => $totalMarks,
                'gpa' => $gpaResult->gpa,
                'grade' => $gpaResult->grade,
                'is_passed' => $isPassed,
            ];

            if ($isPassed) {
                $passedStudents++;
            }
            if ($totalMarks > $highestMarks) {
                $highestMarks = $totalMarks;
            }
        }

        $this->resultSummary = [
            'total_students' => $totalStudents,
            'passed_students' => $passedStudents,
            'failed_students' => $totalStudents - $passedStudents,
            'pass_rate' => $totalStudents > 0 ? round(($passedStudents / $totalStudents) * 100, 2) : 0,
            'highest_marks' => $highestMarks,
        ];
    }

    public function downloadSingleMarksheet($studentId)
    {
        if (!$this->selectedExam) { return; }
        
        $student = Student::find($studentId);
        if (!$student) { return; }

        $student->load(['marks' => function ($query) {
            $query->where('exam_id', $this->selectedExam)->with('subject');
        }, 'schoolClass']);

        $exam = Exam::find($this->selectedExam);
        $data = [
            'student' => $student,
            'exam' => $exam,
            'school_info' => [
                'name' => 'Protiva Laboratory School',
                'address' => 'Bangla Bazar, Kathalbari, Shibchar, Madaripur',
                'logo' => public_path('logo.png'), 
            ],
        ];

        $pdf = Pdf::loadView('reports.marksheet', $data);
        return response()->streamDownload(fn() => print($pdf->output()), "marksheet-{$student->roll_number}.pdf");
    }

    public function render()
    {
        $exams = Exam::orderBy('name')->get();
        $baseClasses = SchoolClass::select('name')->distinct()->orderBy('name')->get(); 
        
        return view('livewire.result.view-result', [
            'exams' => $exams,
            'baseClasses' => $baseClasses,
        ]);
    }
}