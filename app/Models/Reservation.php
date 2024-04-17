<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Reservation extends Model
{
    public $table = 'reservations';
    use HasFactory;

    protected $fillable = [
        'apartment_id',
        'user_id',
        'check_in',
        'check_out',
        'total_price',
        'payment_status'
    ];
    public function search($keyword)
    {
        // show all data when search box is null
        $query = DB::table('users')
            ->join('reservations', 'users.id', '=', 'reservations.user_id')
            ->join('apartment', 'apartment.id', '=', 'reservations.apartment_id')
            ->Join('categories', 'categories.id', '=', 'apartment.category_id')
            ->select(
                'apartment.id as apartment_id',
                'users.id as user_id',
                'users.name as user_name',
                'users.email',
                'categories.name as categ_name',
                'apartment.room_number',
                'apartment.building',
                (DB::raw('DATE_FORMAT(reservations.check_in, "%b-%d-%Y") as check_in_date')),
                (DB::raw('DATE_FORMAT(reservations.check_out, "%b-%d-%Y") as check_out_date')),
                'reservations.total_price',
                'reservations.payment_status',
                'apartment.building'
            )->orderBy('reservations.created_at');
        // this statement will show the data that is %like% the search input
        if (!empty($keyword)) {
            $query->where('users.name', 'like', '%' . $keyword . '%')
            ->orWhere('categories.name', 'like', '%' . $keyword . '%')
            ->orWhere('users.email', 'like', '%' . $keyword . '%')
            ->orWhere( 'apartment.status', 'like', '%' . $keyword . '%')
            ->orWhere( 'apartment.room_number', 'like', '%' . $keyword . '%')
            ->orWhere( 'apartment.building', 'like', '%' . $keyword . '%')
            ->orWhere( 'reservations.check_in', 'like', '%' . $keyword . '%')
            ->orWhere( 'reservations.check_out', 'like', '%' . $keyword . '%')
            ->orWhere( 'reservations.payment_status', 'like', '%' . $keyword . '%')
            ->orWhere('apartment.price', 'like', '%' . $keyword . '%');
        }
        return $query->get();
    }

}
