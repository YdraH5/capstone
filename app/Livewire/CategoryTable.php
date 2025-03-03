<?php

namespace App\Livewire;
use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Validate; 
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Mail\NotifyRentPriceChange; // Ensure this mailable is created
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class CategoryTable extends Component
{   
    use WithPagination;
    public $deleteId;
    public $isEditing= false;// to only run the form when the user clicked the edit icon
    public $id; // to save the id that the user want to edit
    public $editCategory;// to save data that use is going to edit
    public $isDeleting = false;
    #[Validate('required|min:5|max:50')] 
    public $name = '';
 
    public $features = [
        'pax'=>'',
        'cr' => false,
        'livingRoom' => false,
        'kitchen' => false,
        'balcony' => false,
        'aircon' => false,
        'bed' => false,
        'parking' => false,
        'otherText' => '',
    ];
    #[Validate('required|numeric')] 
    public $price = '';
    public function edit($id){
        $this->isEditing = true;
        $this->id = $id;

        $this->editCategory = Category::find($id);
        $this->name = $this->editCategory->name;
        $this->price = $this->editCategory->price;
        $this->features = json_decode($this->editCategory->description, true);
         // Ensure defaults if decoding fails
         if (json_last_error() !== JSON_ERROR_NONE) {
            $this->features = [
                'pax'=> '',
                'cr' => false,
                'livingRoom' => false,
                'kitchen' => false,
                'balcony' => false,
                'aircon' => false,
                'bed' => false,
                'parking' => false,
                'otherText' => '',
            ];
        }

    }
    public function update()
    {
    $this->validate([
        'name' => 'required|max:50|unique:categories,name,' . $this->id,
        'price' => 'required|numeric',
    ]);

    $descriptionJson = json_encode($this->features);

    $category = Category::find($this->id);
    if ($category) {
        // Check if the price has changed
        $oldPrice = $category->price;
        $newPrice = $this->price;

        // Update the category
        $category->update([
            'name' => $this->name,
            'price' => $newPrice,
            'description' => $descriptionJson,
        ]);

        // Update due dates for all future months
        $nextMonthStart = now()->addMonth()->startOfMonth();

        DB::table('due_dates')
            ->join('apartment', 'due_dates.user_id', '=', 'apartment.renter_id')
            ->where('apartment.category_id', $this->id)
            ->where('due_dates.payment_due_date', '>=', $nextMonthStart)
            ->update(['due_dates.amount_due' => $newPrice]);

        // Notify users if the price has changed
        if ($oldPrice != $newPrice) {
            $this->notifyUsersOfPriceChange($this->id, $newPrice);
        }
    }

    $this->reset();
    session()->flash('success', 'Category updated successfully.');
}

public function notifyUsersOfPriceChange($categoryId, $newPrice)
{
    // Retrieve all users associated with the updated category
    $users = DB::table('users')
        ->join('apartment', 'users.id', '=', 'apartment.renter_id')
        ->where('apartment.category_id', $categoryId)
        ->select('users.id', 'users.name', 'users.email')
        ->get();

        $currentUser = Auth::user();

    // Notify each user
    foreach ($users as $user) {
        // Prepare email data
        $emailData = [
            'name' => $user->name,
            'newPrice' => number_format($newPrice, 2),
            'updatedBy' => $currentUser ? $currentUser->name : 'System', // Include updater's name

        ];

        // Send the email
            Mail::to($user->email)->send(new NotifyRentPriceChange($emailData));
    }
       
}
    public function delete($id){
        $this->isDeleting = true;
        $this->deleteId = $id;
    }
    public function deleted(){
        $delete = Category::find($this->deleteId)->delete();
        if($delete){
            session()->flash('success', 'Category deleted successfully.');
            $this->reset();
        }
        $this->isDeleting=false;
    }
    public function render()
    {
        $categories = Category::cursorPaginate(10);
        return view('livewire.owner.category-table', [
            'categories' => $categories,
        ]);    }
}
