<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show Register Form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle Registration Form
     */
    public function register(Request $request)
    {
        $data = $request->all();

        $data['phone'] = ltrim($data['phone'], '0');

        Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'numeric', 'digits_between:10,15', 'unique:users,phone'],
            'referral_code' => ['required', 'exists:users,my_referral_code'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ])->validate();

        // Upload temporary image
        if ($request->hasFile('profile_photo')) {

            $tempPath = $request->file('profile_photo')
                ->store('temp_profiles', 'public');

            $data['profile_photo'] = $tempPath;
        }

        // Store registration data in session
        Session::put('register_data', $data);

        // Redirect to membership offer
        return redirect()->route('membership.offer');
    }
}