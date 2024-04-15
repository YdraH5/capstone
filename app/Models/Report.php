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
    public function search($keyword)
    {
        // show all data when search box is null
        $query = DB::table('reports')
            ->leftjoin('users', 'users.id', '=', 'reports.user_id')
            ->leftjoin('apartment','apartment.renter_id','=','reports.user_id')
            ->select('users.name','reports.id' ,'reports.report_category','apartment.building','reports.description','reports.status','reports.ticket','apartment.room_number',(DB::raw('DATE_FORMAT(reports.created_at, "%b-%d-%Y") as date')));
        // this statement will show the data that is %like% the search input
        if (!empty($keyword)) {
            $query->where('users.name', 'like', '%' . $keyword . '%')
            ->orWhere('reports.report_category', 'like', '%' . $keyword . '%')
            ->orWhere( 'reports.description', 'like', '%' . $keyword . '%')
            ->orWhere( 'reports.status', 'like', '%' . $keyword . '%')
            ->orWhere( 'reports.ticket', 'like', '%' . $keyword . '%')
            ->orWhere('apartment.room_number', 'like', '%' . $keyword . '%');
        }
        return $query->get();
    }
}
