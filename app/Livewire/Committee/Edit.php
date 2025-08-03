<?php
namespace App\Livewire\Committee;
use App\Models\Committee;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]

class Edit extends Component
{
    public Committee $committee;
    public $name;
    public $designation;
    public $phone;
    public $email;
    public $session_year;
    public function mount(Committee $committee)
    {
        $this->committee = $committee;
        $this->name = $committee->name;
        $this->designation = $committee->designation;
        $this->phone = $committee->phone;
        $this->email = $committee->email;
        $this->session_year = $committee->session_year;
    }
    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:committees,phone,' . $this->committee->id,
            'email' => 'nullable|email|max:255|unique:committees,email,' . $this->committee->id,
            'session_year' => 'required|string|max:255',
        ]);
        $this->committee->update($this->all());
        session()->flash('message', 'Committee member updated successfully.');
        return $this->redirect('/committees', navigate: true);
    }
    public function render()
    {
        return view('livewire.committee.edit');
    }
}