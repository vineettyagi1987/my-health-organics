<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Str;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15'],
            'referral_code' => ['required', 'exists:users,my_referral_code'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_photo' => ['required','image','mimes:jpg,jpeg,png','max:2048'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */


// protected function create(array $data)
// {
//     $profilePhoto = null;
//     $idCard = null;
//     $lastUser = User::whereNotNull('my_referral_code')
//     ->orderBy('id', 'desc')
//     ->first();
//     if ($lastUser && $lastUser->my_referral_code) {
//         // Extract number (e.g., STN001 → 001)
//         $number = (int) substr($lastUser->my_referral_code, 3);
//         $nextNumber = $number + 1;
//     } else {
//         $nextNumber = 1;
//     }
//     $myReferralCode = 'STN' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
//     if (request()->hasFile('profile_photo')) {

//         $file = request()->file('profile_photo');

//         $photoName = time().'.'.$file->getClientOriginalExtension();

//         $file->move(public_path('profiles'), $photoName);

//         $profilePhoto = 'profiles/'.$photoName;

//         $photoPath = public_path($profilePhoto);

//         // Load frame first
//         $frame = Image::read(public_path('idcard/frame.png'));

//         $frameWidth  = $frame->width();
//         $frameHeight = $frame->height();

//         // Crop user photo from center
//           $photo = Image::read($photoPath)->cover(650,650,'top');

//         // Create canvas same size as frame
//         $canvas = Image::create($frameWidth, $frameHeight);

//         // Place photo in center
//         $canvas->place($photo, 'center');

//         // Overlay frame on top
//         $canvas->place($frame, 'center');

//         // Save generated ID card
//         $idCardName = time().'_idcard.png';

//         $canvas->save(public_path('idcards/'.$idCardName));

//         $idCard = 'idcards/'.$idCardName;
//     }

//     return User::create([
//         'name' => $data['name'],
//         'email' => $data['email'],
//         'phone' => $data['phone'],
//         'referral_code' => $data['referral_code'],
//         'my_referral_code' => $myReferralCode,
//         'password' => Hash::make($data['password']),
//         'profile_photo' => $profilePhoto,
//         'id_card' => $idCard
//     ]);
// }

// protected function create(array $data)
// {
//     $profilePhoto = null;
//     $idCard = null;

//     // ================================
//     // 🔢 Generate Referral Code
//     // ================================
//     $lastUser = User::whereNotNull('my_referral_code')
//         ->orderBy('id', 'desc')
//         ->first();

//     $nextNumber = 1;

//     if ($lastUser && preg_match('/STN(\d+)/', $lastUser->my_referral_code, $matches)) {
//         $nextNumber = (int)$matches[1] + 1;
//     }

//     $myReferralCode = 'STN' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

//     // ================================
//     // 📸 Upload Profile Photo
//     // ================================
//     if (request()->hasFile('profile_photo')) {

//         $file = request()->file('profile_photo');
//         $photoName = time().'.'.$file->getClientOriginalExtension();
//         $file->move(public_path('profiles'), $photoName);

//         $profilePhoto = 'profiles/'.$photoName;
//         $photoPath = public_path($profilePhoto);

//         // ================================
//         // 🎨 Create Background Canvas
//         // ================================
//         $width = 800;
//         $height = 1100;

//         $canvas = Image::create($width, $height)->fill('#e3f2fd'); // sky bg

//         // ================================
//         // 🧑 User Photo (circle area)
//         // ================================
//         $photo = Image::read($photoPath)->cover(400, 400,'top');

//         // place slightly upper
//         $canvas->place($photo, 'center', 0, -120);

//         // ================================
//         // 🎯 Frame Overlay
//         // ================================
//         $frame = Image::read(public_path('idcard/roundframe.png'))->resize(650, 650);

//         $canvas->place($frame, 'center', 0, -120);

//         // ================================
//         // 🟦 Bottom Blue Strip
//         // ================================
//         $bgStrip = Image::create($width, 300)->fill('#1565C0');

//         $canvas->place($bgStrip, 'bottom');
//           $canvas->text('Save The Nature Trust', $width / 2, 850, function ($font) {
//             $font->file(public_path('fonts/arial.ttf'));
//             $font->size(35);
//             $font->color('#FFD700'); // gold
//             $font->align('center');
//             $font->valign('middle');
//         });

//         // ================================
//         // 📝 Name
//         // ================================
//         $canvas->text($data['name'], $width / 2, 900, function ($font) {
//             $font->file(public_path('fonts/arial.ttf'));
//             $font->size(50);
//             $font->color('#ffffff');
//             $font->align('center');
//             $font->valign('middle');
//         });

//         // ================================
//         // 🧾 Member Volunteer
//         // ================================
//         $canvas->text('Member Volunteer', $width / 2, 950, function ($font) {
//             $font->file(public_path('fonts/arial.ttf'));
//             $font->size(35);
//             $font->color('#FFD700'); // gold
//             $font->align('center');
//             $font->valign('middle');
//         });

//         // ================================
//         // 🆔 ID Number
//         // ================================
//         $canvas->text('ID: ' . $myReferralCode, $width / 2, 1000, function ($font) {
//             $font->file(public_path('fonts/arial.ttf'));
//             $font->size(40);
//             $font->color('#ffff00');
//             $font->align('center');
//             $font->valign('middle');
//         });

         
//           $canvas->text('www.thehealthorganics.com', $width / 2, 1050, function ($font) {
//             $font->file(public_path('fonts/arial.ttf'));
//             $font->size(25);
//             $font->color('#FFD700'); // gold
//             $font->align('center');
//             $font->valign('middle');
//         });

//         // ================================
//         // 💾 Save ID Card
//         // ================================
//         $idCardName = time().'_idcard.png';
//         $canvas->save(public_path('idcards/'.$idCardName));

//         $idCard = 'idcards/'.$idCardName;
//     }

//     // ================================
//     // 💾 Save User
//     // ================================
//     return User::create([
//         'name' => $data['name'],
//         'email' => $data['email'],
//         'phone' => $data['phone'],
//         'referral_code' => $data['referral_code'],
//         'my_referral_code' => $myReferralCode,
//         'password' => Hash::make($data['password']),
//         'profile_photo' => $profilePhoto,
//         'id_card' => $idCard
//     ]);
// }

protected function create(array $data)
{
    $manager = new ImageManager(new Driver());

    $profilePhoto = null;
    $idCard = null;

    // ================================
    // 🔢 Generate Referral Code
    // ================================
    $lastUser = User::whereNotNull('my_referral_code')
        ->orderBy('id', 'desc')
        ->first();

    $nextNumber = 1;

    if ($lastUser && preg_match('/STN(\d+)/', $lastUser->my_referral_code, $matches)) {
        $nextNumber = (int)$matches[1] + 1;
    }

    $myReferralCode = 'STN' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

    // ================================
    // 📸 Upload Profile Photo
    // ================================
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
        $canvas->text($data['name'], $width / 2, 850, function ($font) {
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

    // ================================
    // 💾 Save User
    // ================================
    return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'referral_code' => $data['referral_code'],
        'my_referral_code' => $myReferralCode,
        'password' => Hash::make($data['password']),
        'profile_photo' => $profilePhoto,
        'id_card' => $idCard
    ]);
}

    protected function registered(Request $request, $user)
    {
        // After successful registration → go to membership page
        return redirect()->route('membership.offer');
    }
}
