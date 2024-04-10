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

        return view('reserve.index',['apartment'=>$apartment,'category'=>$categories]);
    }
    public function create(Request $request){
        $data = $request->validate([
            'apartment_id' => 'required|numeric',//I have to add |unique:reservations,user_id here for final code
            'user_id' => 'required|numeric',
            'check_in'=>'required|date_format:Y-m-d',
            'check_out'=>'required|date_format:Y-m-d',
            'total_price'=>'required|numeric',
            'payment_status'=>'required'
        ]);
        // get the user id inside rerservation where the user_id is match to the current users logged in
        foreach($data as $user_id)
        // update the users role to reserve so the the user could access reserve page
        DB::table('users')
        ->where('id', $user_id)
        ->update(['role' => 'reserve']);

        //store the data to database
        Reservation::create($data);

        return redirect(route('reserve.wait'));

    }
    public function waiting(){
        $user = auth()->user();
        $reserve_date = Reservation::select('check_in','apartment_id','id')->where('user_id', '=', $user->id)->limit(1)->get();
        return view('reserve.wait',['reservations'=>$reserve_date]);
    }
    public function edit(){
        return view('reserve.edit');
    }
    public function update(int $user_id,int $apartment_id,int $reservation){
        // to update the user role to renter when button is clicked
        $update_user = DB::table('users')
                    ->where('id', $user_id)
                    ->update(['role' => 'renter']);
        $update_apartment = DB::table('apartment')
                    ->where('id', $apartment_id)
                    ->update(['renter_id' => $user_id]);
        $delete_reservation = DB::table('reservations')
                    ->where('id',$reservation)
                    ->delete();
         if ($update_user && $update_apartment && $delete_reservation === false) {
            // Handle the error here, for example:
            return response()->json(['error' => 'Failed to update user role'], 500);
            } else {
            return redirect(route('renters.index'))->with('success','Hi!, Welcome to renters dashboard. Please enjoy your stay here in NRN Building please let us know if there is a problem');
        }
    }
}
