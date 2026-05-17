<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SubscriptionController extends Controller
{
    /**
     * Membership Offer Page
     */
    public function offer()
    {
        if (!session()->has('register_data')) {
            return redirect()->route('register');
        }

        return view('subscriptions.offer');
    }

    /**
     * Create Razorpay Subscription
     */
    public function subscribe()
    {
        if (!session()->has('register_data')) {
            return redirect()->route('register');
        }

        $api = new Api(
            config('razorpay.key'),
            config('razorpay.secret')
        );

        $rzpSub = $api->subscription->create([
            'plan_id' => config('razorpay.membership_plan'),
            'customer_notify' => 1,
            'total_count' => 1,
        ]);

        session([
            'razorpay_subscription_id' => $rzpSub['id']
        ]);

        return view('subscriptions.pay', [
            'subscription_id' => $rzpSub['id']
        ]);
    }

    /**
     * Payment Success
     */
    public function paymentSuccess(Request $request)
    {
        $data = session('register_data');

        if (!$data) {
            return redirect()->route('register');
        }

        // ==================================
        // Generate Referral Code
        // ==================================

        $lastUser = User::whereNotNull('my_referral_code')
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;

        if ($lastUser && preg_match('/STN(\d+)/', $lastUser->my_referral_code, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        }

        $myReferralCode = 'STN' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // ==================================
        // Move Temp Profile Image
        // ==================================

        $tempPath = storage_path('app/public/' . $data['profile_photo']);

        if (!file_exists(public_path('profiles'))) {
            mkdir(public_path('profiles'), 0777, true);
        }

        $newPhotoName = time().'.png';

        $newPhotoPath = public_path('profiles/'.$newPhotoName);

        copy($tempPath, $newPhotoPath);

        $profilePhoto = 'profiles/'.$newPhotoName;

        // ==================================
        // Generate ID Card
        // ==================================

        $manager = new ImageManager(new Driver());

        $width = 800;
        $height = 1100;

        $canvas = $manager->create($width, $height)
            ->fill('#f5f5f5');

        $canvas->text('Save The Nature', $width / 2, 100, function ($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(60);
            $font->color('#22c55e');
            $font->align('center');
            $font->valign('middle');
        });

        // User Image
        $photo = $manager->read($newPhotoPath)
            ->cover(350, 350, 'top');

        $img = imagecreatefromstring($photo->toPng());

        $w = imagesx($img);
        $h = imagesy($img);

        imagealphablending($img, false);
        imagesavealpha($img, true);

        $trans = imagecolorallocatealpha($img, 0, 0, 0, 127);

        for ($x = 0; $x < $w; $x++) {

            for ($y = 0; $y < $h; $y++) {

                $dx = $x - $w / 2;
                $dy = $y - $h / 2;

                if (($dx * $dx + $dy * $dy) > pow($w / 2, 2)) {
                    imagesetpixel($img, $x, $y, $trans);
                }
            }
        }

        ob_start();

        imagepng($img);

        $circleImage = $manager->read(ob_get_clean());

        $canvas->place($circleImage, 'center', 0, -80);

        // Frame
        $frame = $manager->read(public_path('idcard/round.png'))
            ->resize(625, 625);

        $canvas->place($frame, 'center', 0, -70);

        // Bottom Strip
        $bottom = $manager->create($width, 350)
            ->fill('#22c55e');

        $canvas->place($bottom, 'bottom');

        // Name
        $canvas->text($data['name'], $width / 2, 850, function ($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(55);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });

        // Role
        $canvas->text('Member Volunteer', $width / 2, 920, function ($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(35);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });

        // Referral ID
        $canvas->text('ID: '.$myReferralCode, $width / 2, 980, function ($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(45);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });

        // Create Folder
        if (!file_exists(public_path('idcards'))) {
            mkdir(public_path('idcards'), 0777, true);
        }

        // Save Card
        $idCardName = time().'_idcard.png';

        $canvas->save(public_path('idcards/'.$idCardName));

        $idCard = 'idcards/'.$idCardName;

        // ==================================
        // Create User
        // ==================================

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'referral_code' => $data['referral_code'],
            'my_referral_code' => $myReferralCode,
            'password' => Hash::make($data['password']),
            'profile_photo' => $profilePhoto,
            'id_card' => $idCard,
        ]);

        // ==================================
        // Create Subscription
        // ==================================

        Subscription::create([
            'user_id' => $user->id,
            'razorpay_subscription_id' => session('razorpay_subscription_id'),
            'status' => 'active',
        ]);

        // ==================================
        // Login User
        // ==================================

        Auth::login($user);

        // ==================================
        // Clear Session
        // ==================================

        session()->forget([
            'register_data',
            'razorpay_subscription_id'
        ]);

        return redirect('/')
            ->with('success', 'Registration completed successfully.');
    }

    /**
     * Payment Failed
     */
    public function paymentFailed()
    {
        session()->forget([
            'register_data',
            'razorpay_subscription_id'
        ]);

        return redirect()->route('register')
            ->with('error', 'Payment failed.');
    }
     public function profile()
    {
        $subscription = Subscription::where('user_id', auth()->id())
            ->latest()
            ->first();

        $api = new Api(
            config('razorpay.key'),
            config('razorpay.secret')
        );

       $subscriptions = $api->subscription->fetch($subscription->razorpay_subscription_id);

       if (!empty($subscriptions['current_start'])) {

            $subscription->start_date = Carbon::createFromTimestamp(
                $subscriptions['current_start']
            );
        }

        if (!empty($subscriptions['current_end'])) {

            $subscription->end_date = Carbon::createFromTimestamp(
                $subscriptions['current_end']
            );
        }

        // if (!empty($subscriptions['status'])) {

        //     $subscription->status = $subscriptions['status'];
        // }

        $subscription->save();

       //dd($subscription);
        return view('subscriptions.profile', compact('subscription','subscriptions'));
    }

    public function cancel($id)
{
    $subscription = Subscription::where('user_id', auth()->id())
        ->findOrFail($id);

    // ✅ Prevent repeat cancel
    if ($subscription->status === 'cancelled') {
        return back()->with('info', 'Subscription already cancelled.');
    }

    $api = new Api(config('razorpay.key'), config('razorpay.secret'));

    try {

        $rzpSub = $api->subscription->fetch($subscription->razorpay_subscription_id);

        // ✅ Allow valid statuses
        if (!in_array($rzpSub['status'], ['active', 'authenticated', 'created'])) {

            // sync DB just in case
            $subscription->update(['status' => 'cancelled']);

            return back()->with('warning', 'Subscription already inactive.');
        }

        // ✅ Cancel immediately
        $api->subscription->cancel($subscription->razorpay_subscription_id, [
            'cancel_at_cycle_end' => 0
        ]);

        // ✅ Update DB
        $subscription->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Auto-debit cancelled. No future charges will be made.');

    } catch (\Exception $e) {

        \Log::error('Cancel Subscription Error: '.$e->getMessage());

        // ✅ Handle already cancelled case
        if (str_contains($e->getMessage(), 'already cancelled')) {
            $subscription->update(['status' => 'cancelled']);
            return back()->with('info', 'Subscription already cancelled.');
        }

        return back()->with('error', $e->getMessage());
    }
}

/** Create new subscription from profile */
    public function create()
    {
        $api = new Api(config('razorpay.key'), config('razorpay.secret'));

        $rzpSub = $api->subscription->create([
            'plan_id' => config('razorpay.membership_plan'),
            'customer_notify' => 1,
            'total_count' => 1,
            'notes' => [
                'user_id' => auth()->id(),
            ],
        ]);

        $subscription = Subscription::create([
            'user_id' => auth()->id(),
            'razorpay_subscription_id' => $rzpSub['id'],
            'status' => 'created',
        ]);

        return view('subscriptions.pay', [
            'subscription_id' => $subscription->razorpay_subscription_id
        ]);
    }
}