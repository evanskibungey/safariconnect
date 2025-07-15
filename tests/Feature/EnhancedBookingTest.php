<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\City;
use App\Models\TransportationService;
use App\Models\ServicePricing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class EnhancedBookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test data
        $this->createTestData();
    }

    protected function createTestData()
    {
        // Create cities
        $this->pickupCity = City::create(['name' => 'Nairobi', 'is_active' => true]);
        $this->dropoffCity = City::create(['name' => 'Mombasa', 'is_active' => true]);
        
        // Create transportation service
        $this->service = TransportationService::create([
            'name' => 'Shared Ride',
            'service_type' => 'shared_ride',
            'description' => 'Test shared ride service',
            'is_active' => true
        ]);
        
        // Create pricing
        $this->pricing = ServicePricing::create([
            'transportation_service_id' => $this->service->id,
            'pickup_city_id' => $this->pickupCity->id,
            'dropoff_city_id' => $this->dropoffCity->id,
            'base_price' => 1500,
            'is_active' => true
        ]);
        
        // Create test user
        $this->testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '+254712345678',
            'password' => Hash::make('password123')
        ]);
    }

    /** @test */
    public function authenticated_user_can_make_booking_without_password()
    {
        // Authenticate the user
        $this->actingAs($this->testUser);
        
        // Make a booking request without password
        $response = $this->postJson('/api/shared-ride/book', [
            'pickup_city_id' => $this->pickupCity->id,
            'dropoff_city_id' => $this->dropoffCity->id,
            'travel_date' => now()->addDay()->format('Y-m-d'),
            'travel_time' => '14:00',
            'passengers' => 2,
            'customer_name' => 'Updated Name',
            'customer_email' => 'test@example.com',
            'customer_phone' => '+254712345679'
            // Note: No password fields included
        ]);
        
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'account_created' => false,
        ]);
        
        // Verify user details were updated
        $this->testUser->refresh();
        $this->assertEquals('Updated Name', $this->testUser->name);
        $this->assertEquals('+254712345679', $this->testUser->phone);
        
        // Verify booking was created and linked to user
        $this->assertDatabaseHas('bookings', [
            'user_id' => $this->testUser->id,
            'customer_email' => 'test@example.com',
            'passengers' => 2
        ]);
    }
    
    /** @test */
    public function unauthenticated_user_still_requires_password()
    {
        // Don't authenticate - user is guest
        
        // Try to make a booking request without password
        $response = $this->postJson('/api/shared-ride/book', [
            'pickup_city_id' => $this->pickupCity->id,
            'dropoff_city_id' => $this->dropoffCity->id,
            'travel_date' => now()->addDay()->format('Y-m-d'),
            'travel_time' => '14:00',
            'passengers' => 2,
            'customer_name' => 'New User',
            'customer_email' => 'newuser@example.com',
            'customer_phone' => '+254787654321'
            // Note: No password fields included
        ]);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    }
    
    /** @test */
    public function unauthenticated_user_can_create_account_with_password()
    {
        // Don't authenticate - user is guest
        
        // Make a booking request with password for new user
        $response = $this->postJson('/api/shared-ride/book', [
            'pickup_city_id' => $this->pickupCity->id,
            'dropoff_city_id' => $this->dropoffCity->id,
            'travel_date' => now()->addDay()->format('Y-m-d'),
            'travel_time' => '14:00',
            'passengers' => 2,
            'customer_name' => 'New User',
            'customer_email' => 'newuser@example.com',
            'customer_phone' => '+254787654321',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);
        
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'account_created' => true,
        ]);
        
        // Verify new user was created
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'name' => 'New User'
        ]);
        
        // Verify booking was created and linked to new user
        $newUser = User::where('email', 'newuser@example.com')->first();
        $this->assertDatabaseHas('bookings', [
            'user_id' => $newUser->id,
            'customer_email' => 'newuser@example.com'
        ]);
    }
    
    /** @test */
    public function existing_user_email_with_wrong_password_fails()
    {
        // Don't authenticate - user is guest
        
        // Try to make booking with existing email but wrong password
        $response = $this->postJson('/api/shared-ride/book', [
            'pickup_city_id' => $this->pickupCity->id,
            'dropoff_city_id' => $this->dropoffCity->id,
            'travel_date' => now()->addDay()->format('Y-m-d'),
            'travel_time' => '14:00',
            'passengers' => 2,
            'customer_name' => 'Test User',
            'customer_email' => 'test@example.com', // Existing user email
            'customer_phone' => '+254712345678',
            'password' => 'wrongpassword',
            'password_confirmation' => 'wrongpassword'
        ]);
        
        $response->assertStatus(422);
        $response->assertJson([
            'error' => 'An account with this email already exists. Please use the correct password or use a different email address.'
        ]);
    }
    
    /** @test */
    public function api_user_current_returns_authenticated_user_data()
    {
        $this->actingAs($this->testUser);
        
        $response = $this->getJson('/api/user/current');
        
        $response->assertStatus(200);
        $response->assertJson([
            'authenticated' => true,
            'user' => [
                'id' => $this->testUser->id,
                'name' => $this->testUser->name,
                'email' => $this->testUser->email,
                'phone' => $this->testUser->phone,
            ]
        ]);
    }
    
    /** @test */
    public function api_user_current_returns_false_for_guest()
    {
        // Don't authenticate
        
        $response = $this->getJson('/api/user/current');
        
        $response->assertStatus(200);
        $response->assertJson([
            'authenticated' => false,
            'user' => null
        ]);
    }
    
    /** @test */
    public function api_user_booking_data_returns_user_statistics()
    {
        $this->actingAs($this->testUser);
        
        // Create some test bookings
        $this->testUser->bookings()->create([
            'booking_reference' => 'TEST001',
            'transportation_service_id' => $this->service->id,
            'customer_name' => $this->testUser->name,
            'customer_email' => $this->testUser->email,
            'customer_phone' => $this->testUser->phone,
            'pickup_city_id' => $this->pickupCity->id,
            'dropoff_city_id' => $this->dropoffCity->id,
            'travel_date' => now()->addDay(),
            'travel_time' => '14:00',
            'passengers' => 2,
            'price_per_unit' => 1500,
            'total_price' => 3000,
            'status' => 'completed'
        ]);
        
        $response = $this->getJson('/api/user/booking-data');
        
        $response->assertStatus(200);
        $response->assertJson([
            'authenticated' => true,
            'statistics' => [
                'total_bookings' => 1,
                'completed_bookings' => 1,
                'total_spent' => 3000,
                'success_rate' => 100.0
            ]
        ]);
    }
}
