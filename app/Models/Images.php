<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;

    protected $fillable = ['url','category_id'];

    public function categoryImage()
    {
        return $this->belongsTo(Category::class);
    }

}
