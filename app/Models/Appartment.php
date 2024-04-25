<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Appartment extends Model
{
    public $table = 'apartment';
    use HasFactory;
    protected $fillable = [
        'building',
        'category_id',
        'price',
        'room_number',
        'status'
    ];    
  
}

