<?php

namespace App\Livewire\Mark;

use Livewire\Component;
use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Mark;
use Livewire\Attributes\Layout;
use Exception;

#[Layout('layouts.app')]
class BulkEntry extends Component
{
    public $selectedExam = '';
    public $textData = '';
    public $successCount = 0;
    public $errorCount = 0;
    public array $processingErrors = [];

    public function processMarks()
    {
        $this->validate([
            'selectedExam' => 'required|exists:exams,id',
            'textData' => 'required|string',
        ]);

        $lines = explode("\n", trim($this->textData));
        $this->successCount = 0;
        $this->errorCount = 0;
        $this->processingErrors = [];

        foreach ($lines as $index => $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            $parts = str_getcsv($line);
            if (count($parts) < 4) {
                $this->errorCount++;
                $this->processingErrors[] = "Line " . ($index + 1) . ": Invalid format. Line: '{$line}'";
                continue;
            }

            $classNameAndSection = trim($parts[0]);
            $rollInput = trim($parts[1]);
            $subjectNameInput = trim($parts[2]);
            $marksInput = trim($parts[3]);
            
            // --- ক্লাস এবং সেকশনকে আলাদা করার নতুন পদ্ধতি ---
            $classParts = explode('-', $classNameAndSection);
            $className = isset($classParts[0]) ? trim($classParts[0]) : '';
            $sectionName = isset($classParts[1]) ? trim($classParts[1]) : null;

            if (empty($className)) {
                 $this->errorCount++;
                 $this->processingErrors[] = "Line " . ($index + 1) . ": Class name could not be determined from '{$classNameAndSection}'.";
                 continue;
            }

            // --- ডেটাবেস থেকে সঠিক ক্লাস ও সেকশন খুঁজে বের করা ---
            $query = SchoolClass::where('name', $className);
            if ($sectionName) {
                $query->where('section', $sectionName);
            } else {
                // যদি CSV তে সেকশন না থাকে, তাহলে সেকশন NULL আছে এমন ক্লাস খুঁজবে
                $query->whereNull('section');
            }
            $class = $query->first();


            // --- বিষয় (Subject) খোঁজা বা তৈরি করা ---
            $subject = Subject::firstOrCreate(['name' => $subjectNameInput]);
            
            if (!$class) {
                $this->errorCount++;
                $this->processingErrors[] = "Line " . ($index + 1) . ": Class '{$className}' with Section '{$sectionName}' not found in the database.";
                continue;
            }

            // --- ছাত্র (Student) খোঁজা ---
            $student = Student::where('school_class_id', $class->id)->where('roll_number', $rollInput)->first();
            if (!$student) {
                $this->errorCount++;
                $this->processingErrors[] = "Line " . ($index + 1) . ": Student with roll '{$rollInput}' not found in Class '{$className}' / Section '{$sectionName}'.";
                continue;
            }
            
            // --- মার্কস ভ্যালিডেশন ---
            if (!is_numeric($marksInput)) {
                 $this->errorCount++;
                 $this->processingErrors[] = "Line " . ($index + 1) . ": Marks '{$marksInput}' is not a valid number. Line: '{$line}'";
                 continue;
            }

            // --- ডেটাবেসে মার্কস সেভ বা আপডেট করা ---
            try {
                Mark::updateOrCreate(
                    [
                        'student_id' => $student->id, 
                        'exam_id' => $this->selectedExam, 
                        'subject_id' => $subject->id
                    ],
                    [
                        'school_class_id' => $class->id, 
                        'marks' => $marksInput
                    ]
                );
                $this->successCount++;
            } catch (Exception $e) {
                $this->errorCount++;
                $this->processingErrors[] = "Line " . ($index + 1) . ": Could not save marks for roll '{$rollInput}'. Error: " . $e->getMessage();
            }
        }
        
        session()->flash('message', "Process completed. {$this->successCount} marks saved, {$this->errorCount} errors found.");
        
        $this->textData = '';
    }

    public function render()
    {
        $exams = Exam::all();
        return view('livewire.mark.bulk-entry', [
            'exams' => $exams
        ]);
    }
}