<?php

namespace App\Livewire;
use Livewire\Attributes\Validate; 
use App\Models\Appartment;
use App\Models\Category;
use App\Models\User;
use App\Models\Building;
use App\Models\Reservation;
use App\Models\DueDate;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Carbon\Carbon;

use Illuminate\Validation\Rule;

class ApartmentTable extends Component
{
    use WithPagination;
    public $editApartment ;
    private $editPrice;
    public $isEditing= false;// to only run the form when the user clicked the edit icon
    public $isDeleting= false;// to only run the form when the user clicked the edit icon

    public $id; // to save the id that the user want to edit
    public $search = ""; // to set an empty string for search
    public $deleteId;

    #[Validate('required')] 
    public $category_id;
 
    #[Validate('required')] 
    public $building_id;
    public $user_id;
    #[Validate('required')] 
    public $status;

    #[Validate('required|numeric')] 
    public $room_number;

    public $check_in,$rental_period;
    public $users;
    public $email;
    public $selectedEmail = null;
    public $apartment_id;
    public Appartment $selectedApartment;

    public $sortDirection="ASC";
    public $sortColumn ="room_number";
    public $perPage = 10;
    public $renter_id;
    public function doSort($column){
        if($this->sortColumn === $column){
            $this->sortDirection = ($this->sortDirection === 'ASC')? 'DESC':'ASC';
            return;
        }
        $this->sortColumn = $column;
        $this->sortDirection = 'ASC';
    }
    public function edit($id){
        $this->isEditing = true;
        $this->id = $id;
        // to set the value of current data to the public variables
        $this->editApartment = Appartment::find($id);
        $this->category_id = $this->editApartment->category_id;
        $this->building_id = $this->editApartment->building_id;
        $this->status = $this->editApartment->status;
        $this->room_number = $this->editApartment->room_number;
         
    }
   
    public function update(){
               // Fetch the maximum units allowed for the selected building
               $maxUnits = DB::table('buildings')
               ->where('id', $this->building_id)
               ->value('units'); // Assuming the column name is 'max_units'
       
               // Count the current number of apartments for the selected building
               $currentCount = DB::table('apartment')
                   ->where('building_id', $this->building_id)
                   ->count();
              
        $this->validate([
            'category_id' => 'required',
            'status' => 'required',
            'room_number' => [
                'required','numeric',
            ],
            // Custom rule to check if the apartment count exceeds the max units
            'building_id' => [
                'required'
            ],
        ]);
         // Find the apartment record by its ID
        $apartment = Appartment::find($this->id);

        // Update the apartment record with the new data
        $apartment->update([
            'category_id' => $this->category_id,
            'building_id' => $this->building_id,
            'status' => $this->status,
            'room_number' => $this->room_number,
            'renter_id' => $this->status === 'Available' ? null : $this->renter_id

        ]);

        $this->reset();
        $this->isEditing = false;
        // Reset the component state
        session()->flash('success', 'Apartment updated successfully.');
    }
    public function close(){
        $this->isEditing = false;
        $this->reset(['category_id','building_id','status','room_number','id','editApartment']);
    }
    public function delete($id){
        $this->isDeleting = true;
        $this->deleteId = $id;
    }
    public function deleted(){
        $delete = Appartment::find($this->deleteId)->delete();
        if($delete){
            session()->flash('success', 'Apartment deleted successfully.');
            $this->reset();
        }
        $this->isDeleting = false;
    }
    public function mount()
    {
        // Initialize with all users having a null role when the component is loaded
        $this->users = User::whereNull('role')->get();
    }
    // function just to save the id of the apartment
    public function saveApartment($id){
        $this->apartment_id = $id;
    }

    //function to search the email for adding an exisiting renters to the apartment or walkin renters
    public function searchUser()
    {
        // If email is provided, filter the users by the email, otherwise show all users with null role
        if (!empty($this->email)) {
            $this->users = User::where('email', 'like', '%' . $this->email . '%')
                ->get();
        } else {
            $this->users = User::whereNull('role')->get(); // Show all users with null role
        }
    }
    // function so that when user clicked the email needed it will save the value to the wire:model
    public function selectUser($user_id,$email)
    {
        $this->user_id = $user_id;
        $this->selectedEmail = $email;
        $this->email = $email;
        $this->users = null; // Hide the suggestions once a user is selected
        
    }

    // function to update user role and apartment information,and to create reservation
    public function saveRenter()
{
    // Validation
    $this->validate([
        'email' => 'required|exists:users,email',
        'check_in' => 'required|date',
        'rental_period' => 'required|integer|min:1',
    ], [
        'email.exists' => 'The email address does not exist in our records.',
    ]);

    // Wrap everything in a database transaction
    DB::beginTransaction();

    try {
        // Find the apartment and user
        $apartment = Appartment::find($this->apartment_id);
        $user = User::find($this->user_id);

        // Update the apartment record
        $apartment->update([
            'renter_id' => $this->user_id,
            'status' => 'Rented',
        ]);

        // Create the reservation
        $reservation = Reservation::create([
            'apartment_id' => $this->apartment_id,
            'user_id' => $this->user_id,
            'check_in' => $this->check_in,
            'rental_period' => $this->rental_period,
            'total_price' => 0, // Assuming price calculation is handled elsewhere
        ]);

        // Set the initial due date to the same day of the check-in date
        $checkInDate = Carbon::parse($this->check_in);
        $dayOfMonth = $checkInDate->day; // Get the day of the check-in
        $dueDate = $checkInDate->copy(); // Initialize with the check-in date

        $category = Appartment::find($apartment->id);
        $price = Category::find($category->category_id);

        // Loop to create due dates for each month based on the rental period
        for ($i = 0; $i < $this->rental_period; $i++) {
            // Adjust due date to the same day in the next month
            $dueDate->addMonth()->day($dayOfMonth);

            // Check if the day doesn't exceed the last day of the month (e.g., no February 30)
            if ($dueDate->day != $dayOfMonth) {
                $dueDate->day = $dueDate->copy()->endOfMonth()->day; // Set to the last valid day
            }

            DueDate::create([
                'user_id' => $user->id,
                'payment_due_date' => $dueDate->copy(),
                'amount_due' => $price->price, // Assuming this is the monthly rent
                'status' => 'not paid',
            ]);
        }

        // Update the user's role
        $user->update(['role' => 'renter']);

        // Commit the transaction if all operations succeed
        DB::commit();

        // Reset the form values
        $this->reset();
        session()->flash('success', 'Adding renter successful.');

    } catch (\Exception $e) {
        // Rollback the transaction if something fails
        DB::rollback();
        session()->flash('error', 'Something went wrong: ' . $e->getMessage());
    }
}

    
    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when search input is updated
    }
    public function render()
    {
        // Start the query with the Apartment model and join the necessary relationships
        $query = Appartment::with(['categories', 'buildings', 'users'])
            ->select(
                'users.name as renters_name',
                'apartment.id',
                'categories.name as categ_name',
                'apartment.room_number',
                'apartment.renter_id',
                'categories.price',
                'apartment.status',
                'buildings.name as building',
                DB::raw('DATE_FORMAT(apartment.created_at, "%b-%d-%Y") as date')
            )
            ->join('categories', 'categories.id', '=', 'apartment.category_id')
            ->join('buildings','buildings.id', '=', 'apartment.building_id')
            ->leftJoin('users', 'users.id', '=', 'apartment.renter_id')
            ->orderBy($this->sortColumn, $this->sortDirection);
        // Filter based on the search
        if (!empty($this->search)) {
            $query->where(function($query) {
                $query->where('users.name', 'like', '%' . $this->search . '%')
                ->orWhere('categories.name', 'like', '%' . $this->search . '%')
                ->orWhere('apartment.status', 'like', '%' . $this->search . '%')
                ->orWhere('users.name', 'like', '%' . $this->search . '%')
                ->orWhere('apartment.room_number', 'like', '%' . $this->search . '%')
                ->orWhere('apartment.building_id', 'like', '%' . $this->search . '%')
                ->orWhere('categories.price', 'like', '%' . $this->search . '%');
            });
        }
    
        // Execute the query and return the results
        $apartments = $query->paginate($this->perPage);
        $categories = Category::all();
        $buildings = Building::all();
    
         // Conditionally render the correct view based on user role
        if (auth()->user()->role === 'admin') {
            return view('livewire.admin.apartment-table', [
                'apartment' => $apartments, 
                'categories' => $categories,
                'buildings' => $buildings,
            ]);
        } elseif (auth()->user()->role === 'owner') {
            return view('livewire.owner.apartment-table', [
                'apartment' => $apartments, 
                'categories' => $categories,
                'buildings' => $buildings,
            ]);
        } else {
            // Handle if user doesn't have the right role
            abort(403, 'Unauthorized action.');
        }
    }
    

}
