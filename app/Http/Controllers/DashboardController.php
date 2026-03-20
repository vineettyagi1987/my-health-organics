<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
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
     $manager = new ImageManager(new Driver());
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
        // 🎨 Canvas
        // ================================
        $width = 800;
        $height = 1100;

        $canvas = $manager->create($width, $height)->fill('#f5f5f5');

        // ================================
        // 🌍 Top Title
        // ================================
        $canvas->text('Save The Nature', $width / 2, 100, function ($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(60);
            $font->color('#22c55e');
            $font->align('center');
            $font->valign('middle');
        });

        // ================================
        // 🧑 User Image (NO MASK)
        // ================================
        $photo = $manager->read($photoPath)->cover(350, 350,'top');

       // create circle via GD
        $img = imagecreatefromstring($photo->toPng());

        $w = imagesx($img);
        $h = imagesy($img);

        imagealphablending($img, false);
        imagesavealpha($img, true);

        $trans = imagecolorallocatealpha($img, 0, 0, 0, 127);

        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                $dx = $x - $w/2;
                $dy = $y - $h/2;
                if (($dx*$dx + $dy*$dy) > pow($w/2, 2)) {
                    imagesetpixel($img, $x, $y, $trans);
                }
            }
        }

        // back to image
        ob_start();
        imagepng($img);
        $circleImage = $manager->read(ob_get_clean());

        // place
        $canvas->place($circleImage, 'center', 0, -80);

        // ================================
        // 🎯 SMART FRAME (white + border)
        // ================================
        $frame = $manager->read(public_path('idcard/round.png'))
            ->resize(625, 625);

        $canvas->place($frame, 'center', 0, -70);

        // ================================
        // 🟩 Bottom Section
        // ================================
        $bottom = $manager->create($width, 350)->fill('#22c55e');
        $canvas->place($bottom, 'bottom');

        // ================================
        // 📝 Name
        // ================================
        $canvas->text($request->name, $width / 2, 850, function ($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(55);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });

        // ================================
        // 🧾 Member Volunteer
        // ================================
        $canvas->text('Member Volunteer', $width / 2, 920, function ($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(35);
            $font->color('#eaffea');
            $font->align('center');
            $font->valign('middle');
        });

        // ================================
        // 🆔 ID Number
        // ================================
        $canvas->text('ID: ' . $myReferralCode, $width / 2, 980, function ($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(45);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });

        // ================================
        // 🌐 Website
        // ================================
        $canvas->text('http://thehealthorganics.com/', $width / 2, 1040, function ($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(28);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });

        // ================================
        // 💾 Save ID Card
        // ================================
        if (!file_exists(public_path('idcards'))) {
            mkdir(public_path('idcards'), 0777, true);
        }

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

