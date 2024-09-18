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
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Mail\Contract;

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
            'rental_period' => 'required|numeric',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|string',
            'receipt' => 'nullable|image|mimes:png,jpg,jpeg', // Making receipt nullable but validated if present
        ]);
    
        if ($data['payment_method'] === 'gcash') {
            return $this->handleGcashPayment($data, $request);
        } else {
            return $this->handleStripePayment($data);
        }
    }
    
    private function handleGcashPayment(array $data, Request $request) {
        $data['payment_status'] = 'paid';
    
        // Handle the image upload
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/receipts/';
            $file->move($path, $filename);
            $data['receipt'] = $path . $filename;
        }
        DB::table('users')
        ->where('id', $data['user_id'])
        ->update(['role' => 'pending']);
        // Save the reservation
        $reservation = Reservation::create([
            'apartment_id' => $data['apartment_id'],
            'user_id' => $data['user_id'],
            'check_in' => $data['check_in'],
            'rental_period' => $data['rental_period'],
            'total_price' => $data['total_price'],
        ]);
    
        Payment::create([
            'reservation_id' => $reservation->id,
            'apartment_id' => $data['apartment_id'],
            'user_id' => $data['user_id'],
            'amount' => $data['total_price'],
            'category' => 'Reservation fee',
            'transaction_id' => null,
            'payment_method' => 'gcash',
            'status' => 'approval',
            'receipt' => $data['receipt'],
        ]);
    
        return redirect()->route('reserve.wait')->with('success', 'Please wait patiently, the admin is verifying your payment and reservation.');
    }
    
    private function handleStripePayment(array $data) {
        $stripe = new \Stripe\StripeClient('sk_test_51PSmA3DXXNLXbAhja04flayIKgxlLKafmgY0BG8j3asXy3rZKDHladG5yY8204bV1JcnBxNic09F7IpMtTrivJAw00lD4MswJX');

    
        $categ = DB::table('apartment')
            ->where('id', $data['apartment_id'])
            ->select('category_id', 'id')
            ->first();
    
        $category = Category::find($categ->category_id);
    
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
            'success_url' => route('reserve.payment_success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('reserve.index', ['apartment' => $categ->id], true),
            'metadata' => [
                'user_id' => $data['user_id'],
                'apartment_id' => $data['apartment_id'],
                'check_in' => $data['check_in'],
                'rental_period' => $data['rental_period'],
                'total_price' => $data['total_price'],
            ],
        ]);
    
        return redirect($session->url);
    }
//     public function cancel(Request $request, $reservationId) {
//     // Find the reservation
//     $reservation = Reservation::find($reservationId);

//     if (!$reservation) {
//         return back()->withErrors('Reservation not found.');
//     }

//     // Retrieve payment details
//     $payment = Payment::where('reservation_id', $reservationId)->first();
//     if ($payment->payment_method === 'stripe') {
//         // Initialize Stripe client
//         $stripe = new \Stripe\StripeClient('sk_test_51PSmA3DXXNLXbAhja04flayIKgxlLKafmgY0BG8j3asXy3rZKDHladG5yY8204bV1JcnBxNic09F7IpMtTrivJAw00lD4MswJX');

//         try {
//             // Refund the payment
//             $refund = $stripe->refunds->create([
//                 'charge' => $payment->transaction_id,
//                     'amount' => '5',

//             ]);
//             // Update the payment status
//             $payment->update(['status' => 'refunded']);
//         } catch (\Exception $e) {
//             return back()->withErrors('Failed to process Stripe refund.');
//         }
//     }

//     // Update the reservation status to 'Cancelled'
//     $reservation->update(['status' => 'Cancelled']);

//     // Update apartment status to 'Available'
//     DB::table('apartment')
//         ->where('id', $reservation->apartment_id)
//         ->update(['status' => 'Available', 'renter_id' => null]);

//     // Optionally update user role if needed
//     DB::table('users')
//         ->where('id', $reservation->user_id)
//         ->update(['role' => 'user']);  // Or whatever role they should return to

//     return redirect()->route('reserve.index', ['apartment' => $reservation->apartment_id])->with('success', 'Reservation has been successfully canceled and refunded.');
// }

    public function paymentSuccess(Request $request) {
        $stripe = new \Stripe\StripeClient('sk_test_51PSmA3DXXNLXbAhja04flayIKgxlLKafmgY0BG8j3asXy3rZKDHladG5yY8204bV1JcnBxNic09F7IpMtTrivJAw00lD4MswJX');
        $session_id = $request->get('session_id');

        try {
            $session = $stripe->checkout->sessions->retrieve($session_id);
        } catch (\Exception $e) {
            return back()->withErrors('Payment confirmation failed.');
        }

        if ($session && $session->payment_status === 'paid') {
            $data = [
                'user_id' => $session->metadata->user_id,
                'apartment_id' => $session->metadata->apartment_id,
                'check_in' => $session->metadata->check_in,
                'rental_period' => $session->metadata->rental_period,
                'total_price' => $session->metadata->total_price,
                'payment_method' => 'stripe',
            ];

            $reservation = Reservation::create($data);

            if ($reservation) {
                DB::table('users')
                    ->where('id', $data['user_id'])
                    ->update(['role' => 'reserve']);

                DB::table('apartment')
                    ->where('id', $data['apartment_id'])
                    ->where('status', 'Available')
                    ->limit(1)
                    ->update(['status' => 'Reserved']);

                Payment::create([
                    'reservation_id' => $reservation->id,
                    'apartment_id' => $data['apartment_id'],
                    'user_id' => $data['user_id'],
                    'amount' => $data['total_price'],
                    'category' => 'Reservation fee',
                    'transaction_id' => $session->id,
                    'status' => 'paid',
                    'payment_method' => 'stripe',
                ]);

                $user = Auth::user();
                Mail::to($user->email)->send(new ReservationSuccess([
                    'name' => $user->name,
                    'payment' => $data['total_price'],
                ]));

                return redirect()->route('reserve.wait')->with('success', 'Reservation and payment confirmed.');
            }
        }

        return back()->withErrors('Reservation could not be created.');
    }    
    public function waiting(Request $request)
    {
        $user = auth()->user();
    
        // Fetch the reservation and payment information
        $reserve_date = DB::table('reservations')
            ->join('payments', 'payments.reservation_id', '=', 'reservations.id')
            ->select(
                'reservations.check_in',
                'reservations.apartment_id',
                'payments.status',
                'reservations.id as reservation_id'
            )
            ->where('reservations.user_id', $user->id) // Note: Prefixed 'user_id' with 'reservations.'
            ->limit(1)
            ->get();
    
        // Pass both the reservation data and the success message
        return view('reserve.wait', [
            'reservations' => $reserve_date,
            'success' => 'Payment has been successful'
        ]);
    }
    
    public function edit(){
        return view('reserve.edit');
    }
    public function update(int $user_id, int $apartment_id, int $reservation)
{
    // Update user role to renter
    $update_user = DB::table('users')
        ->where('id', $user_id)
        ->update(['role' => 'renter']);
    
    // Update apartment details
    $update_apartment = DB::table('apartment')
        ->where('id', $apartment_id)
        ->update(['renter_id' => $user_id, 'status' => 'Rented']);

    // If there was an error updating the user or apartment, return error response
    if ($update_user && $update_apartment === false) {
        return response()->json(['error' => 'Failed to update user role'], 500);
    } else {
        // Lease contract data
        $user = Auth::user();
        $reservation_info = Reservation::find($reservation);
        $apartment = Appartment::find($apartment_id);
        $price = Category::find($apartment->category_id);
        
        // Calculate start and end dates
        $start_date = \Carbon\Carbon::parse($reservation_info->check_in);
        $end_date = $start_date->copy()->addMonths($reservation_info->rental_period); // Add months to start date

        $data = [
            'tenant_name' => $user->name,
            'landlord_name' => 'Rose Denolo Nillos',
            'address' => 'Mission Hills, Barangay Milibili, Roxas City, Capiz',
            'start_date' => $start_date->format('Y-m-d'),
            'rental_period' => $end_date->format('Y-m-d'), // Include calculated end date
            'rent_amount' => $price->price,
        ];

        // Render the HTML content from the Blade view to generate the PDF
        $html = view('emails.contract', compact('data'))->render();

        // Initialize DomPDF
        $pdfOptions = new Options();
        $pdfOptions->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output the PDF as a string
        $pdfOutput = $dompdf->output();

        // Send the email with the PDF attached
        Mail::to($user->email)->send(new Contract($data, $pdfOutput));

        return redirect(route('renters.home'))
            ->with('success', 'Hi! Welcome to the renters dashboard. Enjoy your stay in NRN Building. Please let us know if there are any problems. Our Lease contract was sent to your registered email please download the PDF file.');
        }
    }

        
}
    
    

