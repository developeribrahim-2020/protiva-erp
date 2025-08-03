<?php

namespace App\Livewire\Subject;

use Livewire\Component;
use App\Models\Subject;

#[Layout('layouts.app')]

class Edit extends Component
{
    public $model;
    public $name;
    public $modelId;

    public function mount($id)
    {
        $this->modelId = $id;
        $this->model = Subject::findOrFail($this->modelId);
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

        session()->flash('message', 'Subject updated successfully.');
        return redirect()->route('subject.index');
    }

    public function render()
    {
        return view('livewire.subject.edit');
    }
}