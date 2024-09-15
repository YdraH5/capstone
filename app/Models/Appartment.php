<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;



class Appartment extends Model
{
    public $table = 'apartment';
    use HasFactory, SoftDeletes, LogsActivity;

        protected $fillable = [
        'building_id',
        'category_id',
        'room_number',
        'status'
    ];    
 
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function buildings()
    {
        return $this->hasMany(Building::class);
    }
    public function dueDates()
    {
        return $this->hasMany(DueDate::class);
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // Log all attributes, not just the specified ones
            ->useLogName('apartment') // Optional: name the log
            ->logOnlyDirty() // Continue to track changes
            ->dontSubmitEmptyLogs(); // Prevent empty logs if nothing is detected to be logged
    }

}

