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

    // to set a search function for livewire
    public function search($keyword)
    {
        // show all data when search box is null
        $query = DB::table('apartment')
            ->join('categories', 'categories.id', '=', 'apartment.category_id')
            ->leftJoin('users', 'users.id', '=', 'apartment.renter_id')
            ->select(
                'categories.id as categ_id',
                'categories.name as categ_name',
                'users.name as renters_name',
                'apartment.id',
                'apartment.room_number',
                'apartment.price',
                'apartment.status',
                'apartment.building'
            );
        // this statement will show the data that is %like% the search input
        if (!empty($keyword)) {
            $query->where('users.name', 'like', '%' . $keyword . '%')
            ->orWhere('categories.name', 'like', '%' . $keyword . '%')
            ->orWhere( 'apartment.status', 'like', '%' . $keyword . '%')
            ->orWhere( 'apartment.room_number', 'like', '%' . $keyword . '%')
            ->orWhere( 'apartment.building', 'like', '%' . $keyword . '%')
            ->orWhere('apartment.price', 'like', '%' . $keyword . '%');
        }
        return $query->get();
    }
  
}

