<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Test booking success modal
     */
    public function testBookingSuccess()
    {
        // Simulate a successful booking response
        $testBookingData = [
            'success' => true,
            'booking_reference' => 'SR' . date('Ymd') . 'TEST01',
            'account_created' => true,
            'user_id' => 1,
            'message' => 'Test booking successful! Your SafariConnect account has been created.',
            'booking_details' => [
                'service' => 'Shared Ride',
                'route' => 'Nairobi → Mombasa',
                'travel_date' => 'Monday, December 25, 2023',
                'travel_time' => '14:30',
                'travel_info' => 'Monday, December 25, 2023 at 14:30',
                'passengers' => 2,
                'total_price' => 3000,
            ],
            'account_info' => [
                'account_created' => true,
                'login_email' => 'test@example.com',
                'user_authenticated' => true
            ]
        ];

        return response()->json($testBookingData);
    }

    /**
     * Show test booking page
     */
    public function showTestBooking()
    {
        return view('test.booking-success');
    }
}
