<?php

namespace App\Livewire\SchoolClass;

use Livewire\Component;
use App\Models\SchoolClass;

#[Layout('layouts.app')]

class Edit extends Component
{
    public $model;
    public $name;
    public $modelId;

    public function mount($id)
    {
        $this->modelId = $id;
        $this->model = SchoolClass::findOrFail($this->modelId);
        $this->name = $this->model->name;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function update()
    {
        $this->validate();
        $this->model->update([
            'name' => $this->name,
        ]);

        session()->flash('message', 'SchoolClass updated successfully.');
        return redirect()->route('schoolclass.index');
    }

    public function render()
    {
        return view('livewire.schoolclass.edit');
    }
}