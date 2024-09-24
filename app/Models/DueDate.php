<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DueDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_id',
        'amount_due',
        'payment_due_date',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->belongsTo(Payment::class);
    }
}
