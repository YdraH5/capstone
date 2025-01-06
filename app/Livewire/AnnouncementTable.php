<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Announcement;

class AnnouncementTable extends Component
{
    public function render()
    {
        $announcements = Announcement::whereNull('deleted_at')->get();
        return view('livewire.admin.announcement-table', [
            'announcements' => $announcements,
        ]);
    }
}
