<?php

namespace App\Livewire\Exam;

use App\Models\Exam;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]

class ManageExams extends Component
{
    use WithPagination;

    public $name;
    public $editingExamId = null;

    protected $rules = [
        'name' => 'required|string|max:255|unique:exams,name',
    ];

    public function saveExam()
    {
        $this->validate();

        Exam::create([
            'name' => $this->name,
        ]);

        session()->flash('message', 'Exam created successfully.');
        $this->reset('name');
    }

    public function editExam($id)
    {
        $exam = Exam::findOrFail($id);
        $this->editingExamId = $exam->id;
        $this->name = $exam->name;
    }

    public function updateExam()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:exams,name,' . $this->editingExamId,
        ]);

        $exam = Exam::findOrFail($this->editingExamId);
        $exam->update(['name' => $this->name]);

        session()->flash('message', 'Exam updated successfully.');
        $this->reset(['name', 'editingExamId']);
    }

    public function deleteExam($id)
    {
        Exam::destroy($id);
        session()->flash('message', 'Exam deleted successfully.');
    }

    public function cancelEdit()
    {
        $this->reset(['name', 'editingExamId']);
    }

    public function render()
    {
        $exams = Exam::latest()->paginate(10);
        return view('livewire.exam.manage-exams', [
            'exams' => $exams,
        ]);
    }
}