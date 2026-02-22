<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Razorpay\Api\Api;
use App\Models\Event;
use App\Models\EventBooking;
use App\Models\EventCategory;
class FrontEventController extends Controller
{
    public function guidance()
    {
        $events = Event::with('faculties','category')->get();
        return view('frontend.events.index',compact('events'));
    }

    public function index(Request $request)
    {

       $query = Event::where('status','active')->with(['faculties','category']);
        // Category dropdown filter
        if ($request->category) {
            $query->where('event_category_id', $request->category);
        }
        if ($request->type == 'guidance') {

            $categories = EventCategory::whereIn('name', ['education','Nature Culture & Moral Care','Farmers & Soil Care'])->get();

            $categoryIds = $categories->pluck('id');

            $query->whereIn('event_category_id', $categoryIds);
        } 
        else  if ($request->type == 'yoga') {

            $categories = EventCategory::whereIn('name', ['Yoga & Meditation','Ayurvedic Doctors'])->get();

            $categoryIds = $categories->pluck('id');

            $query->whereIn('event_category_id', $categoryIds);
        } 
        else {
            $categories = EventCategory::all();
        }

        $events = $query->latest()->get();

        return view('frontend.events.index', compact('events','categories'));


    }

    public function book($id)
    {
      
        $event = Event::findOrFail($id);

        // Check Subscription
         $isSubscribed = Subscription::where('user_id', auth()->id())
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            })
            ->exists();
           
        if($isSubscribed == true) {

            EventBooking::create([
                'user_id'=>auth()->id(),
                'event_id'=>$event->id,
                'amount'=>0,
                'status'=>'free'
            ]);

            // return redirect()->back()->with('success','Booked Free via Subscription');
             return redirect()->route('my.bookings')
               ->with('success','Booked Free via Subscription');
        }

        // Paid booking
        $api = new Api(config('razorpay.key'), config('razorpay.secret'));

        $order = $api->order->create([
            'receipt'=>uniqid(),
            'amount'=>$event->price * 100,
            'currency'=>'INR'
        ]);

        EventBooking::create([
            'user_id'=>auth()->id(),
            'event_id'=>$event->id,
            'amount'=>$event->price,
            'payment_id'=>$order['id'],
            'status'=>'pending'
        ]);

        return view('frontend.events.payment',compact('order','event'));
    }

    public function paymentSuccess(Request $request)
    {
        $booking = EventBooking::where('payment_id',$request->razorpay_order_id)->first();

        $booking->update([
            'status'=>'paid',
            'payment_id'=>$request->razorpay_payment_id
        ]);

        // return redirect()->route('events.index')
        //        ->with('success','Payment Successful & Event Booked');
         return redirect()->route('my.bookings')
               ->with('success','Payment Successful & Event Booked');
    }
    public function myBookings()
    {
        
        $bookings = EventBooking::with('event.faculties')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('frontend.events.my-bookings', compact('bookings'));
    }
}