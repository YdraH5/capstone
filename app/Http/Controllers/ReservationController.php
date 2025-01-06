<?php

namespace App\Http\Controllers;

use App\Models\Appartment;
use App\Models\Payment;
use App\Models\Category;
use App\Models\User;
use App\Models\DueDate;
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
    public function index($apartment, Request $request){

        $checkin = $request->query('checkin');
        $rentalPeriod = $request->query('rentalPeriod');
        $floorNumber = $request->query('floorNumber');
        $adults = $request->query('adults');
        $children = $request->query('children');
        $infants = $request->query('infants');
        $pets = $request->query('pets');

        $apartment = DB::table('apartment')
        ->rightjoin('categories', 'categories.id', '=', 'apartment.category_id')
        ->leftjoin('users', 'users.id', '=', 'apartment.renter_id')
        ->select('categories.name as categ_name','categories.id as categ_id','categories.description','apartment.id','categories.price','apartment.status','users.id AS user_id')
        ->where('apartment.id',$apartment)
        ->where('apartment.status','Available')
        ->get();
        
        foreach ($apartment as $id)
        $category = Category::all()->where('id',$id->categ_id);

        return view('reserve.index', compact('apartment','category', 'checkin', 'rentalPeriod', 'floorNumber', 'adults', 'children', 'infants', 'pets'));
    }
    public function create(Request $request) {
        $data = $request->validate([
            'apartment_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'check_in' => 'required|date_format:Y-m-d',
            'occupants'=>'required|numeric',
            'rental_period' => 'required|numeric',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);
    
        if ($data['payment_method'] === 'gcash') {
            return $this->handleGcashPayment($data, $request);
        } else {
            return $this->handleStripePayment($data);
        }
    }
    
    private function handleGcashPayment(array $data, Request $request) {

        $request->validate([
            'receipt' => 'required|image|mimes:png,jpg,jpeg', // Making receipt nullable but validated if present
        ]);
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
        DB::table('apartment')
        ->where('id', $data['apartment_id'])
        ->update(['status' => 'Under Review']);
        // Save the reservation
        $reservation = Reservation::create([
            'apartment_id' => $data['apartment_id'],
            'user_id' => $data['user_id'],
            'check_in' => $data['check_in'],
            'occupants'=> $data['occupants'],
            'rental_period' => $data['rental_period'],
            'total_price' => $data['total_price'],
            'status' => 'Pending',
        ]);
    
        Payment::create([
            'reservation_id' => $reservation->id,
            'apartment_id' => $data['apartment_id'],
            'user_id' => $data['user_id'],
            'amount' => $data['total_price'],
            'category' => 'Reservation fee',
            'transaction_id' => null,
            'payment_method' => 'gcash',
            'status' => 'pending',
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
                'occupants'=> $data['occupants'],
                'rental_period' => $data['rental_period'],
                'total_price' => $data['total_price'],
            ],
        ]);
    
        return redirect($session->url);
    }
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
                'occupants'=> $session->metadata->occupants,
                'payment_method' => 'stripe',
                'status' => 'approved'
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
                'reservations.created_at',
                'payments.status',
                'reservations.status as reserve_status',
                'reservations.id as reservation_id'
            )
            ->where('reservations.user_id', $user->id) // Note: Prefixed 'user_id' with 'reservations.'
            ->whereNot('reservations.status','canceled')
            ->limit(1)
            ->get();
        $category = Appartment::where('id',$reserve_date->pluck('apartment_id'))
                    ->select('category_id')
                    ->get();
                    foreach($category as $categ){
                        $categoryImages = DB::table('category_images')
                            ->where('category_id', $categ->category_id)
                            ->get();
                    }
        // Pass both the reservation data and the success message
        return view('reserve.wait', [
            'reservations' => $reserve_date,
            'images' =>$categoryImages,
            'success' => 'Payment has been successful'
        ]);
    }
    
    public function edit(){
        return view('reserve.edit');
    }
    public function update(int $user_id, int $apartment_id, int $reservation)
    {
        // Start a database transaction
        DB::beginTransaction();
    
        try {
            // Update user role to renter
            $update_user = DB::table('users')
                ->where('id', $user_id)
                ->update(['role' => 'renter']);
            
            // Update apartment details
            $update_apartment = DB::table('apartment')
                ->where('id', $apartment_id)
                ->update(['renter_id' => $user_id, 'status' => 'Rented']);
    
            // If there was an error updating the user or apartment, throw an exception
            if (!$update_user || !$update_apartment) {
                throw new \Exception('Failed to update user role or apartment');
            }
    
            // Lease contract data
            $user = Auth::user();
            $reservation_info = Reservation::find($reservation);
            $apartment = Appartment::find($apartment_id);
            $price = Category::find($apartment->category_id);
            
            // Calculate start date and rental period
            $start_date = \Carbon\Carbon::parse($reservation_info->check_in);
            $rental_period = $reservation_info->rental_period;
    
            // Loop to create due dates for each month based on the rental period
            for ($i = 0; $i < $rental_period; $i++) {
                // Create due date for each month
                $dueDate = $start_date->copy()->addMonths($i);
                $dayOfMonth = $start_date->day;
    
                // Check if the day exceeds the last day of the month
                if ($dueDate->day != $dayOfMonth) {
                    $dueDate->day = $dueDate->copy()->endOfMonth()->day; // Set to the last valid day
                }
    
                DueDate::create([
                    'user_id' => $user->id,
                    'payment_due_date' => $dueDate,
                    'amount_due' => $price->price, // Monthly rent
                    'status' => 'not paid',
                ]);
            }
    
            // Prepare data for email
            $end_date = $start_date->copy()->addMonths($rental_period); // Add months to start date
    
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
    
            // Commit the transaction if all operations succeed
            DB::commit();
    
            return redirect(route('renters.home'))
                ->with('success', 'Hi! Welcome to the renters dashboard. Enjoy your stay in NRN Building. Please let us know if there are any problems. Our Lease contract was sent to your registered email; please download the PDF file.');
    
        } catch (\Exception $e) {
            // Roll back the transaction if any error occurs
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

        
}
    
    

