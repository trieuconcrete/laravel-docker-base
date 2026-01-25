<?php

namespace App\Http\Controllers;

use App\Models\DriverBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriverBookingController extends Controller
{
    /**
     * Store a new driver booking request
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{10}$/|max:20',
            'pickup_location' => 'required|string|max:500',
            'dropoff_location' => 'nullable|string|max:500',
            'distance' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Vui lòng nhập họ tên',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.regex' => 'Số điện thoại phải là 10 chữ số',
            'pickup_location.required' => 'Vui lòng nhập điểm đón',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the booking
        $booking = DriverBooking::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'pickup_location' => $request->pickup_location,
            'dropoff_location' => $request->dropoff_location,
            'distance' => $request->distance,
            'price' => $request->price,
            'notes' => $request->notes,
            'status' => 'pending',
            'booking_date' => now(),
        ]);

        // TODO: Send email notification to admin
        // TODO: Send SMS confirmation to customer

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đặt xe! Chúng tôi sẽ liên hệ lại trong vòng 5 phút.');
    }

    /**
     * Display all bookings (for admin)
     */
    public function index(Request $request)
    {
        $query = DriverBooking::query();

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Update booking status
     */
    public function updateStatus(Request $request, DriverBooking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,assigned,completed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}
