<?php
namespace App\Livewire\Committee;
use App\Models\Committee;
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

    public function toggleStatus(Committee $committee)
    {
        $committee->update(['is_active' => !$committee->is_active]);
        session()->flash('message', 'Status updated successfully.');
    }

    public function deleteCommittee(Committee $committee)
    {
        if ($committee->image) Storage::disk('public')->delete($committee->image);
        $committee->delete();
        session()->flash('message', 'Committee member deleted successfully.');
    }
    
    public function printIdCard(Committee $committee)
    {
        $data = [ 'committee' => $committee, /* ... school info ... */ ];
        $pdf = Pdf::loadView('reports.committee-id-card', $data)->setPaper([0, 0, 243.79, 153.07], 'landscape');
        return response()->streamDownload(fn() => print($pdf->output()), "id-card-{$committee->name}.pdf");
    }

    public function render()
    {
        $committees = Committee::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('designation', 'like', '%'.$this->search.'%')
            ->latest()->paginate(10);

        return view('livewire.committee.index', ['committees' => $committees]);
    }
}