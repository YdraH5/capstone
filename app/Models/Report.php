<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Report extends Model
{
    use HasFactory;
    use SoftDeletes,LogsActivity;

    protected $fillable = [
        'report_category',
        'description',
        'is_anonymous',
        'user_id',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['report_category', 'description', 'user_id']) // Specify fields to log
            ->useLogName('report') // Optional: name the log
            ->logOnlyDirty() // Optional: log only when changes are made
            ->dontSubmitEmptyLogs(); // Optional: prevent logging if no fields changed
    }
}
