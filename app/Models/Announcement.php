<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Announcement extends Model
{
    public $table = 'announcements';
    use HasFactory, SoftDeletes, LogsActivity;
    protected $fillable = [
        'category',
        'title',
        'content',
        'priority',
        'status',
        'start_date'
        ];
        public function getActivitylogOptions(): LogOptions
        {
            return LogOptions::defaults()
                ->logAll() // Log all attributes, not just the specified ones
                ->useLogName('Announcement') // Optional: name the log
                ->logOnlyDirty() // Continue to track changes
                ->dontSubmitEmptyLogs(); // Prevent empty logs if nothing is detected to be logged
        }
}
