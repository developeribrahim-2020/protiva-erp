<?php
namespace App\Livewire\Staff;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]

class Create extends Component
{
    use WithFileUploads;

    public $name, $designation, $phone, $address, $joining_date, $image;
    public $email, $password;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:staff,phone',
            'address' => 'nullable|string',
            'joining_date' => 'required|date',
            'image' => 'nullable|image|max:1024',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        
        $imagePath = $this->image ? $this->image->store('staff', 'public') : null;

        Staff::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'designation' => $validated['designation'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'joining_date' => $validated['joining_date'],
            'email' => $validated['email'],
            'image' => $imagePath,
        ]);

        session()->flash('message', 'Staff created successfully with login access.');
        return $this->redirect(route('administration.staff.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.staff.create');
    }
}