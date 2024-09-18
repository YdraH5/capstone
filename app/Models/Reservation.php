<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Reservation extends Model
{
    public $table = 'reservations';
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'apartment_id',
        'user_id',
        'check_in',
        'rental_period',
        'total_price'
        ];
        public function user()
        {
            return $this->belongsTo(User::class);
        }
        public function getActivitylogOptions(): LogOptions
        {
            return LogOptions::defaults()
                ->logAll() // Log all attributes, not just the specified ones
                ->useLogName('reservation') // Optional: name the log
                ->logOnlyDirty() // Continue to track changes
                ->dontSubmitEmptyLogs(); // Prevent empty logs if nothing is detected to be logged
        }
}
