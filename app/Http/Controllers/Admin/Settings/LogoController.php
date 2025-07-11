<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class LogoController extends Controller
{
    /**
     * Show the logo management page
     */
    public function index()
    {
        $currentLogo = $this->getCurrentLogoPath();
        
        return view('admin.settings.logo.index', compact('currentLogo'));
    }

    /**
     * Upload and update the logo
     */
    public function upload(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'logo_type' => 'required|in:main,favicon'
        ]);

        try {
            $logoType = $request->input('logo_type', 'main');
            
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                
                // Generate filename based on logo type
                $filename = $logoType === 'favicon' ? 'favicon.' . $file->getClientOriginalExtension() : 'safarikonnect-logo.' . $file->getClientOriginalExtension();
                
                // Define the path in public/images
                $destinationPath = public_path('images');
                
                // Create directory if it doesn't exist
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }
                
                // Delete old logo if it exists
                $this->deleteOldLogo($logoType);
                
                // Move the file to public/images
                $file->move($destinationPath, $filename);
                
                // Clear any cached logo paths
                Cache::forget('app_logo_path');
                Cache::forget('app_favicon_path');
                
                return redirect()->back()->with('success', ucfirst($logoType) . ' logo uploaded successfully!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error uploading logo: ' . $e->getMessage());
        }

        return redirect()->back()->with('error', 'No file uploaded.');
    }

    /**
     * Delete the current logo
     */
    public function delete(Request $request)
    {
        $request->validate([
            'logo_type' => 'required|in:main,favicon'
        ]);

        try {
            $logoType = $request->input('logo_type', 'main');
            
            if ($this->deleteOldLogo($logoType)) {
                Cache::forget('app_logo_path');
                Cache::forget('app_favicon_path');
                
                return redirect()->back()->with('success', ucfirst($logoType) . ' logo deleted successfully!');
            }
            
            return redirect()->back()->with('error', 'Logo not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting logo: ' . $e->getMessage());
        }
    }

    /**
     * Get the current logo path
     */
    private function getCurrentLogoPath()
    {
        $logoExtensions = ['png', 'jpg', 'jpeg', 'gif', 'svg'];
        
        foreach ($logoExtensions as $ext) {
            $logoPath = public_path("images/safarikonnect-logo.{$ext}");
            if (File::exists($logoPath)) {
                return "images/safarikonnect-logo.{$ext}";
            }
        }
        
        return null;
    }

    /**
     * Get the current favicon path
     */
    private function getCurrentFaviconPath()
    {
        $faviconExtensions = ['ico', 'png', 'jpg', 'jpeg', 'gif', 'svg'];
        
        foreach ($faviconExtensions as $ext) {
            $faviconPath = public_path("favicon.{$ext}");
            if (File::exists($faviconPath)) {
                return "favicon.{$ext}";
            }
        }
        
        return null;
    }

    /**
     * Delete old logo files
     */
    private function deleteOldLogo($logoType = 'main')
    {
        $extensions = ['png', 'jpg', 'jpeg', 'gif', 'svg', 'ico'];
        $deleted = false;
        
        foreach ($extensions as $ext) {
            if ($logoType === 'favicon') {
                $filePath = public_path("favicon.{$ext}");
            } else {
                $filePath = public_path("images/safarikonnect-logo.{$ext}");
            }
            
            if (File::exists($filePath)) {
                File::delete($filePath);
                $deleted = true;
            }
        }
        
        return $deleted;
    }

    /**
     * Get logo URL for use in views (Helper method)
     */
    public static function getLogoUrl()
    {
        return Cache::remember('app_logo_path', 3600, function () {
            $logoExtensions = ['png', 'jpg', 'jpeg', 'gif', 'svg'];
            
            foreach ($logoExtensions as $ext) {
                $logoPath = public_path("images/safarikonnect-logo.{$ext}");
                if (File::exists($logoPath)) {
                    return asset("images/safarikonnect-logo.{$ext}");
                }
            }
            
            // Return default/fallback logo
            return asset('images/default-logo.png');
        });
    }

    /**
     * Get favicon URL for use in views (Helper method)
     */
    public static function getFaviconUrl()
    {
        return Cache::remember('app_favicon_path', 3600, function () {
            $faviconExtensions = ['ico', 'png', 'jpg', 'jpeg', 'gif', 'svg'];
            
            foreach ($faviconExtensions as $ext) {
                $faviconPath = public_path("favicon.{$ext}");
                if (File::exists($faviconPath)) {
                    return asset("favicon.{$ext}");
                }
            }
            
            // Return default favicon
            return asset('favicon.ico');
        });
    }
}
