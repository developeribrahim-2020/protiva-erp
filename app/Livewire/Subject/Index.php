<?php

namespace App\Livewire\Subject;

use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $subjects = Subject::where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.subject.index', [
            'subjects' => $subjects,
        ]);
    }
}