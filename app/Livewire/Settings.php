<?php
namespace App\Livewire;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Settings extends Component
{
    use WithFileUploads;

    public $school_name;
    public $eiin;
    public $address;
    public $phone;
    public $email;
    public $logo;
    public $existing_logo;

    public function mount()
    {
        $this->school_name = setting('school_name', 'Your School Name');
        $this->eiin = setting('eiin', '139704');
        $this->address = setting('address', 'Your Address');
        $this->phone = setting('phone', '');
        $this->email = setting('email', '');
        $this->existing_logo = setting('logo');
    }

    public function saveSettings()
    {
        $validated = $this->validate([
            'school_name' => 'required|string|max:255',
            'eiin' => 'required|string|max:20',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|max:1024',
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'logo' && $this->logo) {
                if ($this->existing_logo) {
                    Storage::disk('public')->delete($this->existing_logo);
                }
                $path = $this->logo->store('settings', 'public');
                Setting::updateOrCreate(['key' => 'logo'], ['value' => $path]);
            } else if ($key !== 'logo') {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        session()->flash('message', 'Settings saved successfully.');
        $this->existing_logo = setting('logo');
        $this->reset('logo');
    }

    public function render()
    {
        return view('livewire.settings');
    }
}