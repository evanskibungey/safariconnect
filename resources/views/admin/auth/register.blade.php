<x-admin-guest-layout :title="'Registration Disabled'" :subtitle="'Enhanced Security Protection'">
    <!-- Security Alert -->
    <div class="text-center mb-8">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
            <i class="fas fa-shield-alt text-red-600 text-2xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">
            Admin Registration Disabled
        </h2>
        <p class="text-gray-600">
            This system is secured with a single admin policy
        </p>
    </div>

    <!-- Security Information -->
    <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-semibold text-red-800 mb-2">
                    Access Restricted
                </h3>
                <div class="text-sm text-red-700 space-y-2">
                    <p>
                        For enhanced security, this system allows only <strong>ONE admin account</strong>.
                        Admin registration has been permanently disabled to prevent unauthorized access.
                    </p>
                    <p>
                        If you need admin access, please contact your system administrator.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Features -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
        <h4 class="text-sm font-semibold text-blue-900 mb-3">
            <i class="fas fa-shield-check text-blue-600 mr-2"></i>
            Security Features Active:
        </h4>
        <div class="grid grid-cols-1 gap-3 text-sm">
            <div class="flex items-start">
                <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                <div>
                    <strong class="text-blue-900">Single Admin Enforcement:</strong>
                    <span class="text-blue-800">Only one administrator account allowed</span>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                <div>
                    <strong class="text-blue-900">Registration Blocking:</strong>
                    <span class="text-blue-800">Public admin registration permanently disabled</span>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                <div>
                    <strong class="text-blue-900">Access Logging:</strong>
                    <span class="text-blue-800">All unauthorized attempts are monitored and logged</span>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                <div>
                    <strong class="text-blue-900">Enhanced Protection:</strong>
                    <span class="text-blue-800">Rate limiting and security middleware active</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alternative Actions -->
    <div class="space-y-4">
        <!-- Login Button -->
        <div class="text-center">
            <a href="{{ route('admin.login') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-white hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Access Admin Login
            </a>
        </div>

        <!-- Contact Information -->
        <div class="text-center pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-600 mb-2">
                Need administrative access?
            </p>
            <div class="text-xs text-gray-500 space-y-1">
                <p>
                    <i class="fas fa-envelope mr-2"></i>
                    Contact your system administrator
                </p>
                <p>
                    <i class="fas fa-terminal mr-2"></i>
                    Use: <code class="bg-gray-100 px-2 py-1 rounded text-xs font-mono">php artisan admin:manage info</code>
                </p>
            </div>
        </div>
    </div>

    <!-- Technical Details for Administrators -->
    <div class="mt-8 p-4 bg-gray-50 border border-gray-200 rounded-lg">
        <h4 class="text-xs font-medium text-gray-800 mb-2">
            <i class="fas fa-cog mr-1"></i>
            For System Administrators:
        </h4>
        <div class="text-xs text-gray-600 space-y-2">
            <p>
                <strong>Admin Management:</strong> Use <code class="bg-gray-100 px-1 rounded font-mono">php artisan admin:manage</code> commands
            </p>
            <p>
                <strong>Create Admin:</strong> <code class="bg-gray-100 px-1 rounded font-mono">php artisan admin:manage create</code>
            </p>
            <p>
                <strong>Reset Password:</strong> <code class="bg-gray-100 px-1 rounded font-mono">php artisan admin:manage reset</code>
            </p>
            <p>
                <strong>Alternative Script:</strong> <code class="bg-gray-100 px-1 rounded font-mono">php manage_admin.php [action]</code>
            </p>
        </div>
    </div>

    <!-- Security Log Notice -->
    <div class="mt-6 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-eye text-yellow-600"></i>
            </div>
            <div class="ml-3">
                <p class="text-xs text-yellow-800">
                    <strong>Security Notice:</strong> This access attempt has been logged with your IP address and timestamp for security monitoring.
                </p>
            </div>
        </div>
    </div>

    <!-- Debug Information for Development -->
    @if (app()->environment('local', 'development'))
    <div class="mt-8 p-4 bg-gray-100 border border-gray-200 rounded-lg">
        <h4 class="text-xs font-medium text-gray-800 mb-2">
            <i class="fas fa-bug mr-1"></i>
            Debug Info (Development Only):
        </h4>
        <div class="text-xs text-gray-600 space-y-1 font-mono">
            <p><strong>Environment:</strong> {{ app()->environment() }}</p>
            <p><strong>Admin Exists:</strong> {{ App\Models\Admin::adminExists() ? 'Yes' : 'No' }}</p>
            @if(App\Models\Admin::adminExists())
                <p><strong>Admin Count:</strong> {{ App\Models\Admin::count() }}</p>
                <p><strong>Admin Email:</strong> {{ App\Models\Admin::getSingleAdmin()->email ?? 'N/A' }}</p>
            @endif
            <p><strong>Registration Blocked:</strong> Yes (Security Policy)</p>
            <p><strong>IP Address:</strong> {{ request()->ip() }}</p>
            <p><strong>User Agent:</strong> {{ request()->userAgent() }}</p>
        </div>
    </div>
    @endif
</x-admin-guest-layout>