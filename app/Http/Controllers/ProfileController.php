<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            $path = $file->store('profile_pictures', 'public');
            $user->profile_picture = $path;
            $user->save();
            $url = Storage::url($path);
            return response()->json(['success' => true, 'url' => $url]);
        }
        return response()->json(['success' => false]);
    }
}
