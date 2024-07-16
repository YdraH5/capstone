<?php

namespace App\Http\Controllers;

use App\Models\Appartment;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationSuccess;
use Illuminate\Support\Facades\Auth;
class ReservationController extends Controller
{
    public $price;
    public function index($apartment){
       
        $apartment = DB::table('apartment')
        ->rightjoin('categories', 'categories.id', '=', 'apartment.category_id')
        ->leftjoin('users', 'users.id', '=', 'apartment.renter_id')
        ->select('categories.name as categ_name','categories.id as categ_id','categories.description','apartment.id','categories.price','apartment.status','users.id AS user_id')
        ->where('apartment.id',$apartment)
        ->where('apartment.status','Available')
        ->get();
        
        foreach ($apartment as $id)
        $categories = Category::all()->where('id',$id->categ_id);

        return view('reserve.index',['apartment'=>$apartment,'category'=>$categories]);
    }
    public function create(Request $request) {
        $data = $request->validate([
            'apartment_id' => 'required|numeric|unique:reservations,user_id',
            'user_id' => 'required|numeric',
            'check_in' => 'required|date_format:Y-m-d',
            'check_out' => 'required|date_format:Y-m-d',
            'total_price' => 'required',
            'payment_method' => 'required|string',
            'receipt' => 'nullable|image|mimes:png,jpg,jpeg', // Making receipt nullable but validated if present
        ]);
    
    
        if ($data['payment_method'] === 'gcash') {
            // Handle Gcash payment
            $data['payment_status'] = 'paid'; // Assuming the payment status is 'paid' for Gcash
    
            // Handle the image upload
            if ($request->hasFile('receipt')) {
                $file = $request->file('receipt');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $path = 'uploads/receipts/';
                $file->move($path, $filename);
                $data['receipt'] = $path . $filename;
            }
    
            // Save the reservation
            $reserve = Reservation::create([
                'apartment_id' => $data['apartment_id'],
                'user_id' => $data['user_id'],
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
                'total_price' => $data['total_price']
                ]);
            $user_id = $data['user_id'];
            
            // if ($reserve) {
            //     DB::table('users')
            //         ->where('id', $user_id)
            //         ->update(['role' => 'reserve']);
            $reservation_id = $reserve->id;
                Payment::create([
                    'reservation_id'=> $reservation_id,
                    'apartment_id' => $data['apartment_id'],
                    'user_id' => $data['user_id'],
                    'amount' => $data['total_price'],
                    'category' => 'Reservation fee',
                    'transaction_id' => null, // No transaction ID for Gcash
                    'payment_method' => 'gcash',
                    'status' => 'approval',
                    'receipt' => $data['receipt']

                ]);
    
                // // Update apartment status to Reserve
                // DB::table('apartment')
                //     ->where('id', $data['apartment_id'])
                //     ->where('status', 'Available')
                //     ->limit(1)
                //     ->update(['status' => 'Reserve']);
            
    
            // Redirect to a success page or a different route
            return redirect()->route('reserve.wait')->with('success', 'Please wait patiently, the admin is verifying your payment and reservation.');
        } else {
            // Handle Stripe payment
            
            $stripe = new \Stripe\StripeClient('sk_test_51PSmA3DXXNLXbAhja04flayIKgxlLKafmgY0BG8j3asXy3rZKDHladG5yY8204bV1JcnBxNic09F7IpMtTrivJAw00lD4MswJX');
            // Retrieve the category ID from the apartment table
            $categ = DB::table('apartment')
                ->where('id', $data['apartment_id'])
                ->select('category_id', 'id')
                ->first();
    
            // Get all the values in the category table that match the ID
            $category = Category::find($categ->category_id);
    
            // Create Stripe session
            $session = $stripe->checkout->sessions->create([
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'php',
                        'product_data' => [
                            'name' => $category->name,
                        ],
                        'unit_amount' => $data['total_price'] * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('reserve.wait', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
                'cancel_url' => route('reserve.index', ['apartment' => $categ->id], true),
            ]);
    
            // Save the reservation
            $reserve = Reservation::create($data);
            $user_id = $data['user_id'];
            if ($reserve) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->update(['role' => 'reserve']);
                // Update apartment status to Reserve
                DB::table('apartment')
                    ->where('id', $data['apartment_id'])
                    ->where('status', 'Available')
                    ->limit(1)
                    ->update(['status' => 'Reserved']);
                $reservation_id = $reserve->id;
                $payment_create = Payment::create([
                    'reservation_id'=> $reservation_id,
                    'apartment_id' => $data['apartment_id'],
                    'user_id' => $data['user_id'],
                    'amount' => $data['total_price'],
                    'category' => 'Reservation fee',
                    'transaction_id' => $session->id,
                    'status' => 'paid',
                    'payment_method' => 'stripe',
                ]);
                $this->price = $payment_create->amount;
            }
            $user = Auth::User();
                    $dataemail = array(
                        'name' => $user->name,
                        'payment' => $this->price,
                    );
            Mail::to($user->email)->send(new ReservationSuccess($dataemail));
            return redirect($session->url);
        }
        
    }
    
  
    public function waiting(Request $request){
        
        $user = auth()->user();
        // $reserve_date = Reservation::select('check_in','apartment_id','id')->where('user_id', '=', $user->id)->limit(1)->get();
        $reserve_date = DB::table('reservations')
                    ->join('payments','payments.reservation_id','=','reservations.id')

                    ->select('reservations.check_in','reservations.apartment_id','payments.status','reservations.id as reservation_id')
                    ->limit(1)->get();
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
                    ->update(['renter_id' => $user_id,'status'=>'Rented']);
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
