<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nearby extends Model
{
    protected $table = 'nearby_establishments';

    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'distance',
        'image_url'
];

}
