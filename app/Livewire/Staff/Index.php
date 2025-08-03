<?php
namespace App\Livewire\Staff;
use App\Models\Staff;
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

    public function toggleStatus(Staff $staff)
    {
        $staff->update(['is_active' => !$staff->is_active]);
        session()->flash('message', 'Staff status updated.');
    }

    public function deleteStaff(Staff $staff)
    {
        if ($staff->image) Storage::disk('public')->delete($staff->image);
        if ($staff->user) $staff->user->delete();
        $staff->delete();
        session()->flash('message', 'Staff deleted successfully.');
    }
    
    public function printIdCard(Staff $staff)
    {
        $data = [ 'staff' => $staff, /* ... school info ... */ ];
        $pdf = Pdf::loadView('reports.staff-id-card', $data)->setPaper([0, 0, 243.79, 153.07], 'landscape');
        return response()->streamDownload(fn() => print($pdf->output()), "id-card-{$staff->name}.pdf");
    }

    public function render()
    {
        $staffs = Staff::where(fn($q) => 
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('designation', 'like', '%'.$this->search.'%')
            )
            ->latest()->paginate(10);

        return view('livewire.staff.index', ['staffs' => $staffs]);
    }
}