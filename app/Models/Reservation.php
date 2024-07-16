<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    public $table = 'reservations';
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'apartment_id',
        'user_id',
        'check_in',
        'check_out',
        'total_price'
        ];
        public function user()
        {
            return $this->belongsTo(User::class);
        }

}
