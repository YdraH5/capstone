<?php

namespace App\Http\Controllers;

use App\Models\Appartment;
use App\Models\Payment;
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
            'apartment_id' => 'required|numeric|unique:reservations,user_id',
            'user_id' => 'required|numeric',
            'check_in'=>'required|date_format:Y-m-d|unique:reservations,check_in',
            'check_out'=>'required|date_format:Y-m-d|unique:reservations,check_out',
            'total_price'=>'required',
            'payment_status'=>'required'
        ]);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        // to retrieve the category id inside apartment table
        $categ = DB::table('apartment')
            ->where('id', $data['apartment_id'])
            ->select('category_id','id')
            ->first();
        // to get all the value in table category that match the id
        $category = Category::find($categ->category_id);
        $session = $stripe->checkout->sessions->create([
            'line_items' => [[
              'price_data' => [
                'currency' => 'php',
                'product_data' => [
                  'name' => $category->name,
                ],
                'unit_amount' => $data['total_price']*100,
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('reserve.wait',[],true)."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('reserve.index', ['apartment' => $categ->id], true),          ]);
            
            $reserve = Reservation::create($data);
            $user_id = $data['user_id'];
            if ($reserve) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->update(['role' => 'reserve']);
                
                    Payment::create([
                        'apartment_id' => $data['apartment_id'],
                        'user_id' => $data['user_id'],
                        'amount' => $data['total_price'],
                        'category' => 'Reservation fee',
                        'transaction_id' => $session->id,
                        'payment_method' => 'stripe', 
                        'status' => $data['payment_status']
                    ]);
            }

          return redirect($session->url);
        }
  
    public function waiting(Request $request){
        // $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        // $sessionId = $request->get('session_id');

        // $session = \Stripe\Checkout\Session::retrieve($sessionId);
        // $customer = \Stripe\Customer::retrieve($session->customer);

        $user = auth()->user();
        $reserve_date = Reservation::select('check_in','apartment_id','id')->where('user_id', '=', $user->id)->limit(1)->get();
        return view('reserve.wait',['reservations'=>$reserve_date])->with('success','Paymenthave been succesful');
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
            return redirect(route('renters.home'))->with('success','Hi!, Welcome to renters dashboard. Please enjoy your stay here in NRN Building please let us know if there is a problem');
        }
    }
    
}
