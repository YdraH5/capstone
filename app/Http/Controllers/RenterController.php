<?php

namespace App\Http\Controllers;

use App\Models\Appartment;
use App\Models\Category;
use App\Models\Reservation;
use App\Models\DueDate;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Mail\Contract;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\ReservationSuccess;


class RenterController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
    
        // Fetch the reservation and payment information
        $reserve_date = DB::table('reservations')
            ->leftjoin('payments', 'payments.reservation_id', '=', 'reservations.id')
            ->join('apartment', 'reservations.apartment_id', '=', 'apartment.id')
            ->join('categories', 'categories.id', '=', 'apartment.category_id')
            ->join('buildings', 'buildings.id', '=', 'apartment.building_id')
            ->select(
                'reservations.check_in',
                'apartment.room_number',
                'categories.name',
                'categories.price',
                'buildings.name',
                'reservations.rental_period', // in months
                'reservations.apartment_id',
                'payments.status',
                'reservations.id as reservation_id'
            )
            ->where('reservations.user_id', $user->id) // Filter by the current user's reservations
            ->limit(1)
            ->get();
    
        // Calculate the end date by adding the rental period (in months) to the check-in date
        $reserve_date->map(function ($reservation) {
            $checkInDate = Carbon::parse($reservation->check_in);
            $reservation->end_date = $checkInDate->addMonths($reservation->rental_period)->toDateString(); // Calculate the end date
    
            // Check if end_date is within the next month
            $reservation->is_next_month = $this->isNextMonth(Carbon::parse($reservation->end_date));
    
            return $reservation;
        });
        
        // Pass both the reservation data and the success message
        return view('renters.home', [
            'reservations' => $reserve_date,
            'due_dates' => DueDate::where('user_id', $user->id)->get(), // Execute the query to get results
            'success' => 'Payment has been successful'
        ]);
    }
    public function pay(Request $request) {
        $data = $request->validate([
            'apartment_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'due_id' => 'required|numeric',
            'amount_due' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);
    
        // Check the payment method and handle accordingly
        if ($data['payment_method'] === 'gcash') {
            return $this->handleGcashPayment($data, $request);
        } elseif ($data['payment_method'] === 'cash') {
            return $this->handleCashPayment($data);
        } else {
            return $this->handleStripePayment($data);
        }
    }
    private function handleCashPayment(array $data) {
        $data['payment_status'] = 'paid'; // Initial status before admin approval
    
        // Create a payment record with status 'approval'
        $payment = Payment::create([
            'apartment_id' => $data['apartment_id'],
            'user_id' => $data['user_id'],
            'amount' => $data['amount_due'],
            'category' => 'Rent Fee',
            'payment_method' => 'cash',
            'status' => 'pending', // Status set for admin approval
            'receipt' => null, // No receipt needed for cash payments
        ]);
    
        // Update the due date status
        DueDate::where('id', $data['due_id'])->update([
            'status' => 'pending',
            'payment_id' => $payment->id,
        ]);
    
        return redirect()->route('renters.home')->with('success', 'Your payment is under verification by our admin.');
    }
        
    private function handleGcashPayment(array $data, Request $request) {

        $request->validate([
            'receipt' => 'required|image|mimes:png,jpg,jpeg',
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
    
        $payment = Payment::create([
            'apartment_id' => $data['apartment_id'],
            'user_id' => $data['user_id'],
            'amount' => $data['amount_due'],
            'category' => 'Rent Fee',
            'payment_method' => 'gcash',
            'status' => 'pending',
            'receipt' => $data['receipt'],
        ]);
    
        DueDate::where('id', $data['due_id'])->update([
            'status' => 'pending',
            'payment_id'=> $payment->id,
        ]);
    
        return redirect()->route('renters.home')->with('success', 'Your payment is under verification by our admin.');
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
                        'name' => 'Rental Fee',
                    ],
                    'unit_amount' => $data['amount_due'] * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('renters.paid', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('renters.home', ['apartment' => $categ->id], true),
            'metadata' => [
                'user_id' => (string) $data['user_id'], // Cast to string
                'due_id' => (string) $data['due_id'], // Cast to string
                'apartment_id' => (string) $data['apartment_id'], // Cast to string
                'amount_due' => (string) $data['amount_due'], // Cast to string
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
                'due_id' => $session->metadata->due_id,
                'apartment_id' => $session->metadata->apartment_id,
                'amount_due' => $session->metadata->amount_due,
                'payment_method' => 'stripe',
            ];
                $payment = Payment::create([
                    'apartment_id' => $data['apartment_id'],
                    'user_id' => $data['user_id'],
                    'amount' => $data['amount_due'],
                    'category' => 'Rental fee',
                    'transaction_id' => $session->id,
                    'status' => 'paid',
                    'payment_method' => 'stripe',
                ]);
                DueDate::where('id', $data['due_id'])->update([
                    'status' => 'paid',
                    'payment_id'=> $payment->id,
                ]);

                return redirect()->route('renters.home')->with('success', 'Payment success.');
            }

        return back()->withErrors('Payments failed');
    } 
    // Function to check if the end date is within the next month
    public function isNextMonth(Carbon $endDate)
    {
        $currentDate = Carbon::now();
    
        // Add 1 month to the current date to check if the end date falls within this period
        $nextMonthDate = $currentDate->addMonth();
    
        // Check if the end date is in the next month
        return $endDate->month === $nextMonthDate->month && $endDate->year === $nextMonthDate->year;
    }
    public function downloadContract(int $user_id, int $apartment_id, int $reservation) {
        // ... Your existing code to generate the PDF ...
        $user = Auth::user();
        $reservation_info = Reservation::find($reservation);
        $apartment = Appartment::find($apartment_id);
        $price = Category::find($apartment->category_id);
    
        // Calculate the end date by adding the rental period (in months)
        $start_date = Carbon::parse($reservation_info->check_in);
        $end_date = $start_date->copy()->addMonths($reservation_info->rental_period);
        $data = [
            'tenant_name' => $user->name,
            'landlord_name' => 'Rose Denolo Nillos',
            'address' => 'Mission Hills, Barangay Milibili, Roxas City, Capiz',
            'start_date' => $start_date->format('Y-m-d'),
            'rental_period' => $end_date->format('Y-m-d'), // Calculate the end date in months
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
        return response()->stream(
            function() use ($dompdf) {
                echo $dompdf->output();
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="contract.pdf"',
            ]
        );
    }
    // public function resend(int $user_id, int $apartment_id, int $reservation){
    
    
    
    
    //     // Send the email with the PDF attached
    //     Mail::to($user->email)->send(new Contract($data, $pdfOutput));
    
    //     return redirect(route('renters.home'))
    //         ->with('success', 'Contract was sent to the email registered.');
    // }
    
    public function extend(Request $request){
        // Validate request data
        $data = $request->validate([
            'extend' => 'required|numeric',
            'reservation_id' => 'required|numeric',
            'apartment_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);
    
        // Increment rental_period for the reservation
        $updated = Reservation::where('id', $data['reservation_id'])->increment('rental_period', $data['extend']);
        
        if (!$updated) {
            return redirect()->back()->with('error', 'Failed to extend the rental period.');
        }
    
        // Fetch updated reservation data
        $user = Auth::user();
        $reservation_info = Reservation::find($data['reservation_id']);
        if (!$reservation_info) {
            return redirect()->back()->with('error', 'Reservation not found.');
        }
        
        $apartment = Appartment::find($data['apartment_id']);
        $price = Category::find($apartment->category_id);
    
        // Calculate new end date
        $start_date = Carbon::parse($reservation_info->check_in);
        $end_date = $start_date->copy()->addMonths($reservation_info->rental_period);
    
        // Prepare data for the contract
        $data = [
            'tenant_name' => $user->name,
            'landlord_name' => 'Rose Denolo Nillos',
            'address' => 'Mission Hills, Barangay Milibili, Roxas City, Capiz',
            'start_date' => $start_date->format('Y-m-d'),
            'rental_period' => $end_date->format('Y-m-d'), // Display actual end date
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
    
        return redirect()->route('renters.home')->with('success', "Extending your stay success. New contract was sent to your email.");
    }    
    
}
