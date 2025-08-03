<?php
namespace App\Livewire\Student;

use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Barryvdh\DomPDF\Facade\Pdf;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedBaseClass = '';
    public $selectedClass = '';
    public $perPage = 10;
    
    public $sectionsAndGroups = [];

    public function updatedSelectedBaseClass($value)
    {
        $this->sectionsAndGroups = $value ? SchoolClass::where('name', $value)->orderBy('section')->get() : [];
        $this->reset('selectedClass');
    }

    public function deleteStudent(Student $student)
    {
        if ($student->image) {
            Storage::disk('public')->delete($student->image);
        }
        $student->delete();
        session()->flash('success', 'Student deleted successfully.');
    }
    
    public function printIdCard(Student $student)
    {
        $data = [
            'student' => $student->load('schoolClass'),
            'school_info' => [
                'name' => 'Protiva Laboratory School',
                'address' => 'Bangla Bazar, Shibchar, Madaripur',
                'logo' => public_path('logo.png'), 
            ]
        ];
        // আপনাকে 'reports.student-id-card' নামে একটি ভিউ ফাইল তৈরি করতে হবে
        $pdf = Pdf::loadView('reports.student-id-card', $data)->setPaper([0, 0, 153.07, 243.79]); // Portrait ID Card (CR80 size)
        
        return response()->streamDownload(fn() => print($pdf->output()), "id-card-{$student->name}.pdf");
    }

    public function render()
    {
        $query = Student::with('schoolClass')
            ->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('roll_number', 'like', '%' . $this->search . '%');
            });
            
        if ($this->selectedClass) {
            $query->where('school_class_id', $this->selectedClass);
        } elseif ($this->selectedBaseClass) {
            $classIds = SchoolClass::where('name', $this->selectedBaseClass)->pluck('id');
            $query->whereIn('school_class_id', $classIds);
        }

        $students = $query->latest()->paginate($this->perPage);
        
        $baseClasses = SchoolClass::select('name')->distinct()->orderBy('name')->get();

        return view('livewire.student.index', [
            'students' => $students,
            'baseClasses' => $baseClasses,
        ]);
    }
}