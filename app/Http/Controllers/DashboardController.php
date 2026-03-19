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

    $myReferralCode = $user->my_referral_code;
    $profilePhoto = $user->profile_photo;
    $idCard = $user->id_card;

    // if($request->hasFile('profile_photo')){

    //     $file = $request->file('profile_photo');

    //     $photoName = time().'.'.$file->getClientOriginalExtension();

    //     $file->move(public_path('profiles'), $photoName);

    //     $profilePhoto = 'profiles/'.$photoName;

    //     $photoPath = public_path($profilePhoto);

    //     // Load frame
    //     $frame = Image::read(public_path('idcard/frame.png'));

    //     $frameWidth  = $frame->width();
    //     $frameHeight = $frame->height();

    //     // Crop photo from center
    //     $photo = Image::read($photoPath)->cover(650,650,'top');

    //     // Create canvas
    //     $canvas = Image::create($frameWidth,$frameHeight);

    //     // Place photo
    //     $canvas->place($photo,'center');

    //     // Overlay frame
    //     $canvas->place($frame,'center');

    //     // Save new id card
    //     $idCardName = time().'_idcard.png';

    //     $canvas->save(public_path('idcards/'.$idCardName));

    //     $idCard = 'idcards/'.$idCardName;
    // }
      if (request()->hasFile('profile_photo')) {

        $file = request()->file('profile_photo');
        $photoName = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('profiles'), $photoName);

        $profilePhoto = 'profiles/'.$photoName;
        $photoPath = public_path($profilePhoto);

        // ================================
        // 🎨 Create Background Canvas
        // ================================
        $width = 800;
        $height = 1100;

        $canvas = Image::create($width, $height)->fill('#e3f2fd'); // sky bg

        // ================================
        // 🧑 User Photo (circle area)
        // ================================
        $photo = Image::read($photoPath)->cover(400, 400,'top');

        // place slightly upper
        $canvas->place($photo, 'center', 0, -120);

        // ================================
        // 🎯 Frame Overlay
        // ================================
        $frame = Image::read(public_path('idcard/frame.png'))->resize(650, 650);

        $canvas->place($frame, 'center', 0, -120);

        // ================================
        // 🟦 Bottom Blue Strip
        // ================================
        $bgStrip = Image::create($width, 300)->fill('#1565C0');

        $canvas->place($bgStrip, 'bottom');
          $canvas->text('Save The Nature Trust', $width / 2, 850, function ($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(35);
            $font->color('#FFD700'); // gold
            $font->align('center');
            $font->valign('middle');
        });

        // ================================
        // 📝 Name
        // ================================
        $canvas->text($request->name, $width / 2, 900, function ($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(50);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });

        // ================================
        // 🧾 Member Volunteer
        // ================================
        $canvas->text('Member Volunteer', $width / 2, 950, function ($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(35);
            $font->color('#FFD700'); // gold
            $font->align('center');
            $font->valign('middle');
        });

        // ================================
        // 🆔 ID Number
        // ================================
        $canvas->text('ID: ' . $myReferralCode, $width / 2, 1000, function ($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(40);
            $font->color('#ffff00');
            $font->align('center');
            $font->valign('middle');
        });

         
          $canvas->text('www.thehealthorganics.com', $width / 2, 1050, function ($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(25);
            $font->color('#FFD700'); // gold
            $font->align('center');
            $font->valign('middle');
        });

        // ================================
        // 💾 Save ID Card
        // ================================
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

