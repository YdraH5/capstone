<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Images;
class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'price',
        'description'
    ];
    protected $dates = ['deleted_at'];

    public function apartments()
    {
        return $this->belongsTo(Appartment::class);
    }
    
    
}
