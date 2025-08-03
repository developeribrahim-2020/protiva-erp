<?php
namespace App\Livewire;
use App\Models\Notice;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Noticeboard extends Component
{
    use WithPagination, WithFileUploads;

    // Form properties
    public $type = 'notice';
    public $title;
    public $content;
    public $attachment;
    public $published_at;
    public $event_datetime;
    public $visibility = 'all';
    public $is_active = true;

    public $editingNoticeId = null;
    public $existing_attachment;
    
    public $showForm = false;
    public $filterType = 'all';

    protected function rules()
    {
        $rules = [
            'type' => 'required|in:notice,event',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'visibility' => 'required|in:all,teachers,students',
            'is_active' => 'boolean',
        ];

        if ($this->type === 'event') {
            $rules['event_datetime'] = 'required|date';
        } else {
            $rules['published_at'] = 'required|date';
        }

        return $rules;
    }

    public function createItem()
    {
        $this->validate();

        $attachmentPath = null;
        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('attachments', 'public');
        }

        Notice::create([
            'type' => $this->type,
            'title' => $this->title,
            'content' => $this->content,
            'attachment' => $attachmentPath,
            'published_at' => $this->type === 'notice' ? $this->published_at : null,
            'event_datetime' => $this->type === 'event' ? $this->event_datetime : null,
            'visibility' => $this->visibility,
            'is_active' => $this->is_active,
            'user_id' => auth()->id(),
        ]);

        session()->flash('message', ucfirst($this->type) . ' created successfully.');
        $this->resetForm();
    }
    
    public function editItem(Notice $item)
    {
        $this->editingNoticeId = $item->id;
        $this->type = $item->type;
        $this->title = $item->title;
        $this->content = $item->content;
        $this->published_at = $item->published_at;
        $this->event_datetime = $item->event_datetime;
        $this->visibility = $item->visibility;
        $this->is_active = $item->is_active;
        $this->existing_attachment = $item->attachment;
        $this->showForm = true;
    }

    public function updateItem()
    {
        $this->validate();
        $item = Notice::findOrFail($this->editingNoticeId);
        
        $attachmentPath = $this->existing_attachment;
        if ($this->attachment) {
            if ($this->existing_attachment) Storage::disk('public')->delete($this->existing_attachment);
            $attachmentPath = $this->attachment->store('attachments', 'public');
        }

        $item->update([
            'type' => $this->type,
            'title' => $this->title,
            'content' => $this->content,
            'attachment' => $attachmentPath,
            'published_at' => $this->type === 'notice' ? $this->published_at : null,
            'event_datetime' => $this->type === 'event' ? $this->event_datetime : null,
            'visibility' => $this->visibility,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', ucfirst($this->type) . ' updated successfully.');
        $this->resetForm();
    }

    public function deleteItem(Notice $item)
    {
        if ($item->attachment) Storage::disk('public')->delete($item->attachment);
        $item->delete();
        session()->flash('message', 'Item deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset(['type', 'title', 'content', 'attachment', 'published_at', 'event_datetime', 'visibility', 'is_active', 'editingNoticeId', 'existing_attachment']);
        $this->showForm = false;
    }

    public function render()
    {
        $query = Notice::with('user');

        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        $items = $query->latest()->paginate(10);
            
        return view('livewire.noticeboard', [
            'items' => $items,
        ]);
    }
}