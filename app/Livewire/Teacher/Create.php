<?php

namespace App\Livewire\Teacher;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Create extends Component
{
    use WithFileUploads;

    // Teacher properties
    public $name;
    public $designation;
    public $phone;
    public $qualification;
    public $address;
    public $joining_date;
    public $image;
    
    // User credentials
    public $email;
    public $password;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:teachers,phone',
            'qualification' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'joining_date' => 'required|date',
            'image' => 'nullable|image|max:1024', // 1MB Max

            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Create a new user for the teacher
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        
        // Assign a role to the user (optional but recommended)
        // $user->assignRole('teacher'); // Make sure you have a role system like Spatie/laravel-permission

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('teachers', 'public');
        }

        // Create the teacher and link to the user
        Teacher::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'designation' => $validated['designation'],
            'phone' => $validated['phone'],
            'qualification' => $validated['qualification'],
            'address' => $validated['address'],
            'joining_date' => $validated['joining_date'],
            'email' => $validated['email'], // Storing email in teachers table as well for convenience
            'image' => $imagePath,
        ]);

        session()->flash('message', 'Teacher created successfully with login access.');

        return $this->redirect('/teachers', navigate: true);
    }

    public function render()
    {
        return view('livewire.teacher.create');
    }
}