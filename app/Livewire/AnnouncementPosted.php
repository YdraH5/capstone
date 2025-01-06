<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Announcement;
use App\Models\Appartment;

class AnnouncementPosted extends Component
{
    public function render()
{
    // Find the apartment based on the logged-in user's ID
    $currentApartment = Appartment::where('renter_id', auth()->user()->id)->first(); 
    
    // Ensure the apartment exists before continuing
    if (!$currentApartment) {
        // Handle case where the apartment is not found (e.g., return an error or empty response)
        return view('livewire.renter.announcement-posted', [
            'announcements' => collect(), // Return an empty collection if no apartment is found
        ]);
    }

    // Get the announcements matching the category of the current apartment
    $announcementsQuery = Announcement::where('status', 'active')
        ->orderBy('start_date', 'desc');
    
    // If the category is not 'all', filter by the current apartment's category
    if ($currentApartment->category_id !== null) {
        $announcementsQuery->where(function ($query) use ($currentApartment) {
            $query->where('category', $currentApartment->category_id)
                ->orWhere('category', 'all'); // Include announcements with 'all' category
        });
    } else {
        // If no category is set for the apartment, show all announcements with 'all' category
        $announcementsQuery->where('category', 'all');
    }

    // Get the filtered announcements
    $announcements = $announcementsQuery->get();
    
    // Return the view with the announcements
    return view('livewire.renter.announcement-posted', [
        'announcements' => $announcements,
    ]);
}

    
}
