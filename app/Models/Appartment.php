<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Appartment extends Model
{
    public $table = 'apartment';
    use HasFactory;
    use SoftDeletes;
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
    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
    public function dueDates()
    {
        return $this->hasMany(DueDate::class);
    }


}

