<?php

namespace App\Http\Controllers;

use App\Models\Appartment;
use App\Models\Category;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Mail\Contract;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RenterController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
    
        // Fetch the reservation and payment information
        $reserve_date = DB::table('reservations')
            ->join('payments', 'payments.reservation_id', '=', 'reservations.id')
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
            'success' => 'Payment has been successful'
        ]);
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
    
    public function resend(int $user_id, int $apartment_id, int $reservation){
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
    
        // Send the email with the PDF attached
        Mail::to($user->email)->send(new Contract($data, $pdfOutput));
    
        return redirect(route('renters.home'))
            ->with('success', 'Contract was sent to the email registered.');
    }
    
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
