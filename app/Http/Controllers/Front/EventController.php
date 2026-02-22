<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventRegistration;
class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('status',1)->with('faculty')->get();
        return view('front.events.index', compact('events'));
    }

    public function show($id)
    {
        $event = Event::with('faculty')->findOrFail($id);
        return view('front.events.show', compact('event'));
    }

    public function register($id)
    {
        $event = Event::findOrFail($id);

        EventRegistration::firstOrCreate([
            'user_id'=>auth()->id(),
            'event_id'=>$event->id
        ],[
            'is_paid'=>$event->price == 0 ? 1 : 0
        ]);

        if($event->price > 0){
            return redirect()->route('payment.page',$event->id);
        }

        return back()->with('success','Registered Successfully');
    }

    public function join($id)
    {
       
        $registration = EventRegistration::where('event_id',$id)
            ->where('user_id',auth()->id())
            ->where('is_paid',1)
            ->firstOrFail();
        dd($registration);
        $event = Event::findOrFail($id);

        return view('front.events.video', compact('event'));
    }
}
