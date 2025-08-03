<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Transaction;
use App\Models\Notice;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    // ডিফল্ট মান সেট করা হলো, যাতে প্রথম লোডে কোনো এরর না আসে
    public $totalStudents = 0;
    public $totalTeachers = 0;
    public $totalClasses = 0;
    public $totalIncome = 0;
    public $totalExpense = 0;
    public $recentNotices = [];
    public $upcomingEvents = [];
    public $readyToLoad = false;

    // এই ফাংশনটি পেজ লোড হওয়ার পর স্বয়ংক্রিয়ভাবে রান হবে
    public function loadDashboardData()
    {
        $this->totalStudents = Student::count();
        $this->totalTeachers = Teacher::count();
        $this->totalClasses = SchoolClass::distinct('name')->count('name');
        $this->totalIncome = Transaction::where('type', 'income')->sum('amount');
        $this->totalExpense = Transaction::where('type', 'expense')->sum('amount');
        // $this->recentNotices = Notice::where('type', 'notice')->latest()->take(3)->get();
        // $this->upcomingEvents = Notice::where('type', 'event')->where('event_datetime', '>=', now())->orderBy('event_datetime')->take(3)->get();
        
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}