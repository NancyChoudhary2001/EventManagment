<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddeventRequest;
use App\Models\Currency;
use App\Models\Event;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AddeventController extends Controller
{
    public function getCountries()
    {
        $currencies = Currency::all();
        return view('admin.add-event', compact('currencies'));
    }
    public function addevent(AddeventRequest $request)
{

    $imagePath = null;
    if ($request->hasFile('event_image')) {
        $file = $request->file('event_image'); 
        $fileName = $file->getClientOriginalName();
        $imagePath = $request->file('event_image')->storeAs('event_images', $fileName , 'public'); // Store image in the 'public/event_images' directory
    }

   
    $event = Event::create([
        'name' => $request->name,
        'description' => $request->description,
        'role' => $request->role,
        'currency_id' => $request->currency, 
        'price' => $request->price, 
        'image' => $imagePath,
    ]);

    
    return response()->json([
        'status' => true,
        'message' => 'Event added successfully.',
        'event' => $event,
    ], 200);
}

public function getEvents(Request $request)
{
    if ($request->ajax()) {
       
        $data = Event::select('id', 'name', 'description', 'price');

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return '
                    <a href="/events/edit/' . $row->name . '" class="btn btn-sm btn-primary">Edit</a>
                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $row->name . '">Delete</button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    return view('admin.events');
}

public function destroy($name)
{
    $event = Event::where('name', $name)->firstOrFail();
    $event->delete();

    return response()->json([
        'status' => true,
        'message' => 'Event deleted successfully!'
    ]);
}

public function edit($name)
{
    
    $event = Event::where('name', $name)->firstOrFail();
    //dd($event->role);

    $currencies = Currency::all();
    return view('admin.edit-event', compact('event', 'currencies')); 
}


public function update(Request $request, $name)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'currency' => 'required|exists:currencies,id',
        'price' => 'required|numeric',
        'visibility' => 'required|in:admin,user',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $event = Event::where('name', $name)->first();

    if ($request->hasFile('image')) {
        
        if ($event->image) {
            Storage::delete('public/' . $event->image);
        }

        $imagePath = $request->file('image')->store('event_images', 'public');
        $event->image = $imagePath;
    }

    $event->name = $validated['name'];
    $event->description = $validated['description'];
    $event->currency_id = $validated['currency'];
    $event->price = $validated['price'];
    $event->role = $validated['visibility'];

    $event->save();

    return redirect()->route('events')->with('success', 'Event updated successfully!');
}

public function buyitem(Request $request)
{
    if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'message' => 'You need to log in to buy an item.'
        ], 401);
    }

    $user = Auth::user();


    $request->validate([
        'event_id' => 'required|exists:events,id',
    ]);

    $eventId = $request->input('event_id');
    $event = Event::find($eventId);

    
    if (!$event) {
        return response()->json([
            'success' => false,
            'message' => 'Event not found.'
        ], 404);
    }

    
    $alreadyPurchased = $user->events()->where('event_id', $eventId)->exists();

    if ($alreadyPurchased) {
        return response()->json([
            'success' => false,
            'message' => 'You have already purchased this event.'
        ], 400);
    }


    if ($event->price > 0) {
        return response()->json([
            'success' => false,
            'message' => 'Gateway is not Implemented. Contect Admin'
        ], 400);
    }

 
    $user->events()->attach($eventId);

    return response()->json([
        'success' => true,
        'message' => 'Event purchased successfully!',
    ], 200);
}


public function showPaymentPage(Request $request)
{
    $event = Event::findOrFail($request->event_id);
    
   
    return view('user-payment', compact('event'));
}

}
