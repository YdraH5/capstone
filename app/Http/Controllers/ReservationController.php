<?php

namespace App\Http\Controllers;

use App\Models\Appartment;
use App\Models\user;
use App\Models\Category;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ReservationController extends Controller
{
    public function index(Appartment $apartment){
       
        $apartment = DB::table('apartment')
        ->join('categories', 'categories.id', '=', 'apartment.category_id')
        ->leftjoin('users', 'users.id', '=', 'apartment.renter_id')
        ->leftjoin('category_images', 'category_images.category_id','=','categories.id')
        ->select('categories.name as categ_name','categories.description','apartment.id','apartment.price','apartment.status','category_images.image','category_images.category_id AS categ_id','users.id AS user_id')
        ->where('apartment.id',$apartment->id)
        ->limit(1)
        ->get();
        foreach ($apartment as $id)
        $categories = Category::all()->where('id',$id->categ_id);
        DB::table('users')
        ->where('id', $id->user_id)
        ->update(['apartment_id' => $id->id]);
        // User::where('id',$id)
        // ->update(['apartment_id'=>$id->user_id]);
        return view('reserve.index',['apartment'=>$apartment,'category'=>$categories]);
    }
    public function create(Request $request){
        $data = $request->validate([
            'apartment_id' => 'required|numeric',
            'user_id' => 'required|numeric|unique:reservations,user_id',
            'check_in'=>'required|date_format:Y-m-d',
            'check_out'=>'required|date_format:Y-m-d',
            'total_price'=>'required|numeric',
            'payment_status'=>'required'
        ]);
    
        // Dumping the validated data for debugging
        Reservation::create($data);
        return redirect(route('reserve.wait'));

    }
    public function waiting(){
        $user = auth()->user();
        $reserve_date = Reservation::select('check_in')->where('user_id', '=', $user->id)->limit(1)->get();
        return view('reserve.wait',['reserveDate'=>$reserve_date]);
    }
}
