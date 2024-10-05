<?php

namespace App\Livewire;
use App\Models\User;
use Livewire\Component;

class AddAdmin extends Component
{
    public $isOpen = false;
    public $selectedEmail;
    public $user_id;
    public $users;
    public $email;
    public $id;
    
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
    public function mount()
    {
        // Initialize with all users having a null role when the component is loaded
        $this->users = User::whereNull('role')->get();
    }
    public function selectUser($user_id,$email)
    {
        $this->user_id = $user_id;
        $this->selectedEmail = $email;
        $this->email = $email;
        $this->users = null; // Hide the suggestions once a user is selected
        
    }
    public function saveAdmin(){
        User::where('id',$this->user_id)->update(['role','admin']);
        redirect()->route('reserve.wait')->with('success', 'Adding admin account success.');    }
    
    public function render()
    {
        $users = User::whereNull('role')->get();
        return view('livewire.owner.add-admin')
            ->with([
            'users' => $users,
    ]);
    }
}
