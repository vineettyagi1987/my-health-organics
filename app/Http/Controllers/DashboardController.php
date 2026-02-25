<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class DashboardController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        return view('profile', compact('user'));
    }


public function updateProfile(Request $request)
{
     $user = auth()->user();

    $request->validate([
        'name'  => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $profilePhoto = $user->profile_photo;
    $idCard = $user->id_card;

    if($request->hasFile('profile_photo')){

        $file = $request->file('profile_photo');

        $photoName = time().'.'.$file->getClientOriginalExtension();

        $file->move(public_path('profiles'), $photoName);

        $profilePhoto = 'profiles/'.$photoName;

        $photoPath = public_path($profilePhoto);

        // Load frame
        $frame = Image::read(public_path('idcard/frame.png'));

        $frameWidth  = $frame->width();
        $frameHeight = $frame->height();

        // Crop photo from center
        $photo = Image::read($photoPath)->cover(650,650,'top');

        // Create canvas
        $canvas = Image::create($frameWidth,$frameHeight);

        // Place photo
        $canvas->place($photo,'center');

        // Overlay frame
        $canvas->place($frame,'center');

        // Save new id card
        $idCardName = time().'_idcard.png';

        $canvas->save(public_path('idcards/'.$idCardName));

        $idCard = 'idcards/'.$idCardName;
    }

    $user->update([
        'name'  => $request->name,
        'phone' => $request->phone,
        'profile_photo' => $profilePhoto,
        'id_card' => $idCard
    ]);

    return back()->with('success','Profile updated successfully.');
}
}

