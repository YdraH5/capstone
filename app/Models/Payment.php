<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'apartment_id',
        'user_id',
        'amount',
        'category',
        'transaction_id',
        'payment_method',
        'status',
        'due_date'
    ];

    public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function apartment()
        {
            return $this->belongsTo(Appartment::class);
        }
}
