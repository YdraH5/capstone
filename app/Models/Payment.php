<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Payment extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'reservation_id',
        'apartment_id',
        'user_id',
        'amount',
        'category',
        'transaction_id',
        'payment_method',
        'status',
        'due_date',
        'receipt'
    ];

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function apartment()
        {
            return $this->belongsTo(Appartment::class);
        }
        public function reservation()
        {
            return $this->belongsTo(Appartment::class);
        }
        public function getActivitylogOptions(): LogOptions
        {
            return LogOptions::defaults()
                ->logAll() // Log all attributes, not just the specified ones
                ->useLogName('payment') // Optional: name the log
                ->logOnlyDirty() // Continue to track changes
                ->dontSubmitEmptyLogs(); // Prevent empty logs if nothing is detected to be logged
        }
}
