<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Building extends Model
{
    public $table = 'buildings';

    use HasFactory,LogsActivity;
    protected $fillable = [
        'name',
        'units',
        'parking_space',
    ];  
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'units', 'parking_space']) // Specify fields to log
            ->useLogName('building') // Optional: name the log
            ->logOnlyDirty() // Optional: log only when changes are made
            ->dontSubmitEmptyLogs(); // Optional: prevent logging if no fields changed
    }
}


