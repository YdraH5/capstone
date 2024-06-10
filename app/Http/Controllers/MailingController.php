<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mailing;
class MailingController extends Controller
{
    public function index(){
        $subject = 'test subject';
        $body = 'Test MEssage';
        Mail::to('hardyaranzanso0930@gmail.com')->send(new Mailing($subject,$body));
    }
}
