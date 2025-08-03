<?php

namespace App\Livewire\SchoolClass;

use App\Models\SchoolClass;
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
        $schoolClasses = SchoolClass::where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.schoolclass.index', [
            'schoolClasses' => $schoolClasses,
        ]);
    }
}