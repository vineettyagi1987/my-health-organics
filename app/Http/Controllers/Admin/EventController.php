<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Faculty;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index()
    {
        $events = Event::with(['category','faculties'])
                        ->latest()
                        ->get();

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $categories = EventCategory::all();
        $faculties  = Faculty::all();

        return view('admin.events.create', compact('categories','faculties'));
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required',
            'event_category_id' => 'required|exists:event_categories,id',
            'event_date'        => 'required|date',
            'event_time'        => 'required',
            'price'             => 'required|numeric|min:0',
            'faculties'         => 'required|array',
            'status'           => 'required|in:active,inactive,completed,cancelled'
        ]);
        // Combine date and time
    $event_datetime = $request->event_date.' '.$request->event_time;
        $event = Event::create([
            'title'             => $request->title,
            'description'       => $request->description,
            'event_category_id' => $request->event_category_id,
            'event_date'        => $event_datetime,
            'price'             => $request->price,
            'meeting_link'      => $request->meeting_link,
            'status'            => $request->status
        ]);

        // Attach multiple faculties
        $event->faculties()->sync($request->faculties);

        return redirect()
                ->route('admin.events.index')
                ->with('success','Event Created Successfully');
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit($id)
    {
        $event      = Event::findOrFail($id);
        $categories = EventCategory::all();
        $faculties  = Faculty::all();

        return view('admin.events.edit',
            compact('event','categories','faculties'));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, $id)
    {
       
        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required',
            'event_category_id' => 'required|exists:event_categories,id',
            'event_date'        => 'required|date',
            'event_time'        => 'required',
            'price'             => 'required|numeric|min:0',
            'faculties'         => 'required|array',
            'status'           => 'required|in:active,inactive,completed,cancelled'
        ]);

        $event = Event::findOrFail($id);
        $event_datetime = $request->event_date.' '.$request->event_time;
        $event->update([
            'title'             => $request->title,
            'description'       => $request->description,
            'event_category_id' => $request->event_category_id,
            'event_date'        => $event_datetime,
            'price'             => $request->price,
            'meeting_link'      => $request->meeting_link,
            'status'            => $request->status
        ]);

        // Sync faculties
        $event->faculties()->sync($request->faculties);

        return redirect()
                ->route('admin.events.index')
                ->with('success','Event Updated Successfully');
    }

    /**
     * Remove the specified event.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        // Detach faculties first
        $event->faculties()->detach();

        $event->delete();

        return redirect()
                ->route('admin.events.index')
                ->with('success','Event Deleted Successfully');
    }
}