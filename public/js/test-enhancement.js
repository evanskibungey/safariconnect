/**
 * Booking Enhancement Verification Script
 * Paste this into browser console to test if enhancement is working
 */

(async function testBookingEnhancement() {
    console.log('🧪 Testing Booking Enhancement...\n');
    
    // Test 1: Check if enhancement script is loaded
    console.log('1️⃣ Checking if BookingFormEnhancer is loaded...');
    if (typeof BookingFormEnhancer !== 'undefined') {
        console.log('✅ BookingFormEnhancer class is available');
    } else {
        console.log('❌ BookingFormEnhancer class not found - script may not be loaded');
        return;
    }
    
    // Test 2: Check user authentication
    console.log('\n2️⃣ Checking user authentication...');
    try {
        const userResponse = await fetch('/api/user/current');
        const userData = await userResponse.json();
        
        if (userData.authenticated) {
            console.log('✅ User is authenticated as:', userData.user.name);
            console.log('📧 Email:', userData.user.email);
            console.log('📱 Phone:', userData.user.phone || 'Not provided');
        } else {
            console.log('❌ User is not authenticated');
            console.log('💡 Enhancement only works for logged-in users');
            return;
        }
    } catch (error) {
        console.log('❌ Error checking authentication:', error);
        return;
    }
    
    // Test 3: Check for booking forms
    console.log('\n3️⃣ Checking for booking forms...');
    const forms = [
        '#shared-ride-form',
        '#solo-ride-form', 
        '#airport-transfer-form',
        '#car-hire-form',
        '#parcel-delivery-form'
    ];
    
    let formsFound = 0;
    let enhancedForms = 0;
    
    forms.forEach(selector => {
        const form = document.querySelector(selector);
        if (form) {
            formsFound++;
            const container = form.closest('[id$="-form-container"]');
            const isEnhanced = container?.dataset?.enhanced === 'true';
            
            console.log(`📋 ${selector}:`, form ? '✅ Found' : '❌ Not found');
            if (form && isEnhanced) {
                enhancedForms++;
                console.log(`   Enhanced: ✅ Yes`);
            } else if (form) {
                console.log(`   Enhanced: ❌ No`);
            }
        }
    });
    
    console.log(`\n📊 Summary: ${formsFound} forms found, ${enhancedForms} enhanced`);
    
    // Test 4: Test API endpoints
    console.log('\n4️⃣ Testing API endpoints...');
    
    const endpoints = [
        '/api/user/current',
        '/api/user/booking-data',
        '/api/cities',
        '/api/vehicle-types'
    ];
    
    for (const endpoint of endpoints) {
        try {
            const response = await fetch(endpoint);
            if (response.ok) {
                console.log(`✅ ${endpoint}: Working`);
            } else {
                console.log(`❌ ${endpoint}: Failed (${response.status})`);
            }
        } catch (error) {
            console.log(`❌ ${endpoint}: Error -`, error.message);
        }
    }
    
    // Test 5: Check for CSRF token
    console.log('\n5️⃣ Checking CSRF token...');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (csrfToken) {
        console.log('✅ CSRF token found');
    } else {
        console.log('❌ CSRF token missing - form submissions may fail');
    }
    
    // Final recommendation
    console.log('\n🎯 RECOMMENDATIONS:');
    
    if (enhancedForms > 0) {
        console.log('✅ Enhancement appears to be working!');
        console.log('💡 Try booking a trip:');
        console.log('   1. Click a service card (e.g., Solo Ride)');
        console.log('   2. Notice pre-filled fields and "You\'re Logged In" section');
        console.log('   3. Fill trip details and click "Complete Booking"');
        console.log('   4. Watch console for submission logs');
    } else {
        console.log('⚠️  Enhancement may not be working properly');
        console.log('💡 Try these steps:');
        console.log('   1. Hard refresh the page (Ctrl+F5)');
        console.log('   2. Make sure you\'re logged in');
        console.log('   3. Click a booking service to open the form');
        console.log('   4. Run this test again');
    }
    
    console.log('\n🔧 DEBUG: If "Complete Booking" doesn\'t work:');
    console.log('   1. Open a booking form');
    console.log('   2. Fill in details');
    console.log('   3. Click "Complete Booking"');
    console.log('   4. Check console for "Enhanced submit handler triggered"');
    console.log('   5. Look for any error messages');
    
    console.log('\n✅ Test completed! Check the results above.');
})();
