<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\User;

class ProfileController extends Controller
{
    public function showPicture()
    {
        return view('profile.picture');
    }

    public function updatePicture(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'profile_picture' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            // Use the default disk (e.g., 'cloudinary' or 'public')
            $path = $file->store('profile_pictures');
            
            $user->profile_picture = $path;
            try {
                $user->save();
            } catch (Exception $e) {
                // Log and return JSON error so the frontend gets a proper response
                Log::error('Failed to save profile picture for user '.$user->id.': '.$e->getMessage());
                return response()->json(['success' => false, 'message' => 'Failed to save profile picture.'], 500);
            }

            // Generate the correct URL based on the configured disk
            $url = $user->profile_picture_url;
            return response()->json(['success' => true, 'url' => $url]);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded.'], 400);
    }
}
