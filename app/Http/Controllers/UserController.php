<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin');
    }
    public function index(){
        $users = User::all();//to get users data from database
        return view('admin.users.index', ['users'=>$users]);
    }
    
}
