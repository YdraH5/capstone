<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Announcement;
use App\Models\Category;

class AnnouncementTable extends Component
{
    public $id;
    public $isDeleting = false;
    public $deleteId,$isEditing,$editAnnouncement,$category,$title,$content,$priority,$status,$start_date;
    public function delete($id){
        $this->isDeleting = true;
        $this->deleteId = $id;
    }
    public function deleted(){
        $delete = Announcement::find($this->deleteId)->delete();
        if($delete){
            session()->flash('success', 'Announcement deleted successfully.');
            $this->reset();
        }
        $this->isDeleting = false;
    }
    public function edit($id){
        $this->isEditing = true;
        $this->id = $id;
        // to set the value of current data to the public variables
        $editAnnouncement = Announcement::find($id);
          // Assign the announcement's data to the component's public properties
        $this->category = $editAnnouncement->category;
        $this->title = $editAnnouncement->title;
        $this->content = $editAnnouncement->content;
        $this->priority = $editAnnouncement->priority;
        $this->status = $editAnnouncement->status;
        $this->start_date = $editAnnouncement->start_date; // If applicable
    }
   
    public function update(){
              
        $this->validate([
            'category' => 'required',
            'title' => 'required',
            'content' => 'required',
            'priority' => 'required',
            'status' => 'required', 
            'start_date' => 'required', 
        ]);
        $announcement = Announcement::find($this->id);
        $announcement->update([
            'category' => $this->category,
            'title' => $this->title,
            'content' => $this->content,
            'priority' => $this->priority,
            'status' => $this->status,
            'start_date' => $this->start_date,
        ]);

        $this->isEditing = false;
        $this->reset();
        // Reset the component state
        session()->flash('success', 'Announcement updated successfully.');
    }

    public function render()
    {
        $categories = Category::whereNull('deleted_at')->get();
        $announcements = Announcement::whereNull('deleted_at')->get();
        return view('livewire.admin.announcement-table', [
            'announcements' => $announcements,
            'categories' => $categories,
        ]);
    }
}
