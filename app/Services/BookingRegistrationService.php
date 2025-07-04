<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;

class BookingRegistrationService
{
    /**
     * Handle user registration or authentication during booking process
     * 
     * @param array $userData
     * @return array
     */
    public function handleUserRegistration(array $userData): array
    {
        $accountCreated = false;
        $user = null;
        
        // Check if user already exists
        $existingUser = User::where('email', $userData['email'])->first();
        
        if ($existingUser) {
            // User exists - verify the password matches
            if (!Hash::check($userData['password'], $existingUser->password)) {
                return [
                    'success' => false,
                    'error' => 'An account with this email already exists. Please use the correct password or use a different email address.',
                    'errors' => [
                        'customer_email' => ['An account with this email already exists.']
                    ]
                ];
            }
            $user = $existingUser;
            
            Log::info('Existing user authenticated during booking', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
        } else {
            // Create new user account
            try {
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'phone' => $userData['phone'],
                    'password' => Hash::make($userData['password']),
                ]);
                
                $accountCreated = true;
                
                // Fire the registered event
                event(new Registered($user));
                
                Log::info('New user account created during booking', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name
                ]);
            } catch (\Exception $e) {
                Log::error('Error creating user account during booking: ' . $e->getMessage());
                return [
                    'success' => false,
                    'error' => 'Unable to create account. Please try again.'
                ];
            }
        }
        
        // Authenticate the user
        Auth::login($user);
        
        return [
            'success' => true,
            'user' => $user,
            'account_created' => $accountCreated
        ];
    }
    
    /**
     * Validate registration data
     * 
     * @param array $data
     * @return array
     */
    public function validateRegistrationData(array $data): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ];
        
        $validator = validator($data, $rules);
        
        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }
        
        return ['success' => true];
    }
    
    /**
     * Check if email is already registered
     * 
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool
    {
        return User::where('email', $email)->exists();
    }
    
    /**
     * Get user by email
     * 
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
