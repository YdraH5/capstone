<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Announcement;

class AnnouncementForm extends Component
{
    public $category;
    public $title;
    public $content;
    public $priority;
    public $status;
    public $start_date;

    public function save()
    {
        $this->validate([
            'category' => 'required',
            'title' => 'required',
            'content' => 'required',
            'priority' => 'required',
            'status' => 'required',
            'start_date' => 'required',
        ]);

        Announcement::create([
            'category' => $this->category,
            'title' => $this->title,
            'content' => $this->content,
            'priority' => $this->priority,
            'status' => $this->status,
            'start_date' => $this->start_date,
        ]);
        return redirect()->route('admin.announcement.index')->with('success', 'Posting Announcement Success');

    }

    public function render()
    {
        $categories = Category::whereNull('deleted_at')->get();
        return view('livewire.admin.announcement-form', [
            'categories' => $categories,
        ]);
    }
}
