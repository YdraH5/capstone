<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    public $table = 'buildings';

    use HasFactory;
    protected $fillable = [
        'name',
        'units',
        'parking_space',
    ];  
}
