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


protected function create(array $data)
{
    $profilePhoto = null;
    $idCard = null;

    if (request()->hasFile('profile_photo')) {

        $file = request()->file('profile_photo');

        $photoName = time().'.'.$file->getClientOriginalExtension();

        $file->move(public_path('profiles'), $photoName);

        $profilePhoto = 'profiles/'.$photoName;

        $photoPath = public_path($profilePhoto);

        // Load frame first
        $frame = Image::read(public_path('idcard/frame.png'));

        $frameWidth  = $frame->width();
        $frameHeight = $frame->height();

        // Crop user photo from center
          $photo = Image::read($photoPath)->cover(650,650,'top');

        // Create canvas same size as frame
        $canvas = Image::create($frameWidth, $frameHeight);

        // Place photo in center
        $canvas->place($photo, 'center');

        // Overlay frame on top
        $canvas->place($frame, 'center');

        // Save generated ID card
        $idCardName = time().'_idcard.png';

        $canvas->save(public_path('idcards/'.$idCardName));

        $idCard = 'idcards/'.$idCardName;
    }

    return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'referral_code' => $data['referral_code'],
        'my_referral_code' => strtoupper(Str::random(8)),
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
