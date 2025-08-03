<?php

namespace App\Livewire\Subject;

use App\Models\Subject;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Create extends Component
{
    public $name;
    public $subject_code;
    public $type;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'subject_code' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
        ]);

        Subject::create($this->all());
        session()->flash('message', 'Subject created successfully.');
        return $this->redirect('/subjects', navigate: true);
    }

    public function render()
    {
        return view('livewire.subject.create');
    }
}