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
        'renter_id',
        'building_id',
        'category_id',
        'room_number',
        'status'
    ];    
 
    public function payments()
    {
        return $this->belongsTo(DueDate::class);
    }
    public function tenant()
    {
        return $this->hasMany(Tenant::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function due_dates()
    {
        return $this->belongsTo(DueDate::class);
    }
    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
    public function buildings()
    {
        return $this->belongsTo(Building::class);
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

