<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Reservation extends Model
{
    public $table = 'reservations';
    use HasFactory;

    protected $fillable = [
        'apartment_id',
        'user_id',
        'check_in',
        'check_out',
        'total_price',
        'payment_status'
    ];
    

}
