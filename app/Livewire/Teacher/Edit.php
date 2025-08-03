<?php

namespace App\Livewire\Teacher;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Edit extends Component
{
    use WithFileUploads;

    public Teacher $teacher;

    // Form properties
    public $name;
    public $designation;
    public $phone;
    public $qualification;
    public $address;
    public $joining_date;
    public $image; // For new image upload
    public $existing_image;

    // User credentials
    public $email;
    public $password;

    public function mount(Teacher $teacher)
    {
        $this->teacher = $teacher;
        $this->name = $teacher->name;
        $this->designation = $teacher->designation;
        $this->phone = $teacher->phone;
        $this->qualification = $teacher->qualification;
        $this->address = $teacher->address;
        $this->joining_date = $teacher->joining_date;
        $this->existing_image = $teacher->image;
        $this->email = $teacher->email;
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:teachers,phone,' . $this->teacher->id,
            'qualification' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'joining_date' => 'required|date',
            'image' => 'nullable|image|max:1024',
            'email' => 'required|email|max:255|unique:users,email,' . $this->teacher->user_id,
            'password' => 'nullable|string|min:8', // Password is optional on update
        ]);

        // Update the associated User record
        if ($this->teacher->user) {
            $this->teacher->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Update password if a new one is provided
            if (!empty($validated['password'])) {
                $this->teacher->user->update([
                    'password' => Hash::make($validated['password']),
                ]);
            }
        }

        $imagePath = $this->existing_image;
        if ($this->image) {
            // Delete old image if it exists
            if ($this->existing_image) {
                Storage::disk('public')->delete($this->existing_image);
            }
            $imagePath = $this->image->store('teachers', 'public');
        }

        // Update the teacher record
        $this->teacher->update([
            'name' => $validated['name'],
            'designation' => $validated['designation'],
            'phone' => $validated['phone'],
            'qualification' => $validated['qualification'],
            'address' => $validated['address'],
            'joining_date' => $validated['joining_date'],
            'email' => $validated['email'],
            'image' => $imagePath,
        ]);

        session()->flash('message', 'Teacher information updated successfully.');
        return $this->redirect('/teachers', navigate: true);
    }

    public function render()
    {
        return view('livewire.teacher.edit');
    }
}