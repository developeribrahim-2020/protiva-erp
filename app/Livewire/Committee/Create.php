<?php
namespace App\Livewire\Committee;
use App\Models\Committee;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Create extends Component
{
    use WithFileUploads;
    public $name, $designation, $phone, $email, $session_year, $address, $image;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:committees,phone',
            'email' => 'nullable|email|max:255|unique:committees,email',
            'session_year' => 'required|string|max:255',
            'address' => 'nullable|string',
            'image' => 'nullable|image|max:1024',
        ]);
        
        $imagePath = $this->image ? $this->image->store('committees', 'public') : null;

        Committee::create(array_merge($validated, ['image' => $imagePath]));

        session()->flash('message', 'Committee member created successfully.');
        return $this->redirect(route('administration.committees.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.committee.create');
    }
}