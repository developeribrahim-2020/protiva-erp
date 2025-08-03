<?php

namespace App\Livewire\Teacher;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Barryvdh\DomPDF\Facade\Pdf;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function toggleStatus(Teacher $teacher)
    {
        $teacher->is_active = !$teacher->is_active;
        $teacher->save();

        if ($teacher->user) {
            // Optionally, you can implement logic to handle user status as well
        }

        session()->flash('message', 'Teacher status updated successfully.');
    }

    public function deleteTeacher(Teacher $teacher)
    {
        // Delete the teacher's image from storage if it exists
        if ($teacher->image) {
            Storage::disk('public')->delete($teacher->image);
        }

        // Delete the associated user if exists
        if ($teacher->user) {
            $teacher->user->delete();
        }

        // Delete the teacher record
        $teacher->delete();

        session()->flash('message', 'Teacher deleted successfully.');
    }
    
    public function printIdCard(Teacher $teacher)
    {
        $data = [
            'teacher' => $teacher,
            'school_info' => [
                'name' => 'Protiva Laboratory School',
                'address' => 'Bangla Bazar, Shibchar, Madaripur',
                'logo' => public_path('logo.png'), 
            ],
        ];

        // আপনাকে 'reports.teacher-id-card' নামে একটি ভিউ ফাইল তৈরি করতে হবে
        $pdf = Pdf::loadView('reports.teacher-id-card', $data)->setPaper([0, 0, 243.79, 153.07], 'landscape'); // ID card size (CR80) in landscape
        
        return response()->streamDownload(fn() => print($pdf->output()), "id-card-{$teacher->name}.pdf");
    }

    public function render()
    {
        $teachers = Teacher::where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('designation', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.teacher.index', [
            'teachers' => $teachers,
        ]);
    }
}