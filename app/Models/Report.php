<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class Report extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'report_category',
        'description',
        'user_id',
        'ticket',
    ];
    
}
