<?php

namespace App\Livewire\SchoolClass;

use App\Models\SchoolClass;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Create extends Component
{
    public $name;
    public $numeric_name;
    public $section;
    public $group;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'numeric_name' => 'nullable|string|max:255',
            'section' => 'nullable|string|max:255',
            'group' => 'nullable|string|max:255',
        ]);

        SchoolClass::create($this->all());

        session()->flash('message', 'Class created successfully.');

        return $this->redirect('/school-classes', navigate: true);
    }

    public function render()
    {
        return view('livewire.schoolclass.create');
    }
}