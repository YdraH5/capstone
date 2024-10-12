<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ViewDetail extends Component
{
    public $adults = 1;
    public $children = 0;
    public $infants = 0;
    public $pets = 0;
    public $showDropdown = false;
    public $categoryId;
    public $available;
    public $room_available;
    public $floorNumber = 'any';  // Default value 'any' for displaying all rooms
    public $roomNumber;  // Stores the selected room number
    public $rooms = [];  // List of available rooms based on the selected floor
    public $apartment;
    public $noRoomsMessage = '';  // Property to hold no rooms message
    public $checkin; // Declare the checkin property
    public $rentalPeriod; // Declare the rentalPeriod property

    public function increaseAdults()
    {
        if ($this->adults < 2) {
            $this->adults++;
        }
    }

    public function decreaseAdults()
    {
        if ($this->adults > 1) {
            $this->adults--;
        }
    }

    public function increaseChildren()
    {
        $this->children++;
    }

    public function decreaseChildren()
    {
        if ($this->children > 0) {
            $this->children--;
        }
    }

    public function increaseInfants()
    {
        $this->infants++;
    }

    public function decreaseInfants()
    {
        if ($this->infants > 0) {
            $this->infants--;
        }
    }

    public function increasePets()
    {
        $this->pets++;
    }

    public function decreasePets()
    {
        if ($this->pets > 0) {
            $this->pets--;
        }
    }

    public function mount($categoryId, $available, $room_available)
    {
        $this->categoryId = $categoryId;
        $this->available = $available;
        $this->room_available = $room_available;
        $this->loadAvailableRooms(); // Load available rooms immediately
    }

    public function loadAvailableRooms()
    {
        $query = DB::table('apartment')
            ->select('apartment.id', 'apartment.room_number', 'apartment.status')
            ->where('apartment.category_id', $this->categoryId)
            ->where('apartment.status', 'Available');

        if ($this->floorNumber !== 'any') {
            // Determine the room number range based on the selected floor
            $floorStart = intval($this->floorNumber) * 100;
            $floorEnd = $floorStart + 99;
            $query->whereBetween('apartment.room_number', [$floorStart, $floorEnd]);
        }

        // Get the available rooms based on the current selection
        $this->rooms = $query->get();

        // Automatically select the room if only one is available
        if ($this->rooms->count() === 1) {
            $this->roomNumber = $this->rooms[0]->id;
        } else {
            $this->roomNumber = null; // Reset if not exactly one room
        }

        // Check if there are no rooms available
        $this->noRoomsMessage = $this->rooms->isEmpty() ? 'No available rooms for this floor.' : '';
    }

    public function updatedFloorNumber()
    {
        $this->loadAvailableRooms();  // Reload rooms based on the selected floor
    }

    public function submitReservation()
    {
        $this->validate([
            'checkin' => 'required|date',
            'rentalPeriod' => 'required|integer|min:1',
            'floorNumber' => 'required',
            'roomNumber' => 'required',
            'adults' => 'integer|min:0',
            'children' => 'integer|min:0',
            'infants' => 'integer|min:0',
            'pets' => 'integer|min:0',
        ]);

        // Prepare the validated data for redirection
        return redirect()->route('reserve.index', [
            'apartment' => $this->roomNumber,
            'checkin' => $this->checkin,
            'rentalPeriod' => $this->rentalPeriod,
            'floorNumber' => $this->floorNumber,
            'adults' => $this->adults,
            'children' => $this->children,
            'infants' => $this->infants,
            'pets' => $this->pets,
        ]);
    }

    public function render()
    {
        return view('livewire.view-detail', [
            'rooms' => $this->rooms,  // Pass the filtered rooms to the view
        ]);
    }
}
