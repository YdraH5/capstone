<?php

namespace App\Http\Controllers;

use App\Mail\NotifyMe;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class NotifyMeController extends Controller
{
   public function notify(){
    
    $id = Auth::User();
    Mail::to($id->email)->send(new NotifyMe($id));
    return back()->with('success','Email sent');
   }
}
