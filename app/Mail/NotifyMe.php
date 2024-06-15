<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class NotifyMe extends Mailable
{
    use Queueable, SerializesModels;
    private User $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

   public function build(){
    return $this->from('hardyaranzanso07@gmail.com')->subject('Notify me')->view('emails.notify')->with('data',$this->data);
   }
}
