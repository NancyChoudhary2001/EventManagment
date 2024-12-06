<?php

namespace App\Http\Controllers;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\AdduserRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Branch;
use App\Models\User;
use App\Models\Event;

use Illuminate\Http\Request;

class AdduserController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
    
       
        $countries = Country::all();
        $states = State::where('country_id', $user->country)->get();
        $cities = City::where('state_id', $user->state)->get();
        $branches = Branch::where('city_id', $user->city)->get();
    
        return view('admin.edit-user', compact('user', 'countries', 'states', 'cities', 'branches'));
    }
    

    
    public function update(Request $request)
    {
        
        $request->validate([
            'id' => 'required|exists:users,id',
            'email' => 'required|email|exists:users,email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'country' => 'required|exists:countries,id',
            'state' => 'required|exists:states,id',
            'city' => 'required|exists:cities,id',
            'pin' => 'required|string|max:10',
            'branch' => 'required|exists:branches,id',
        ]);
    
        
        $user = User::findOrFail($request->id);
    
        
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'pincode' => $request->pin,
            'branch_id' => $request->branch,
        ]);
    
       
        return redirect()->route('index')->with('success', 'User updated successfully.');
    }
    


    public function index()
    {
        return view('admin.index');
    }
    public function getUser(Request $request)
{
    if ($request->ajax()) {
       
        $query = User::with('branch'); 

       
        return Datatables::eloquent($query)
            ->addColumn('action', function ($row) {
                return '<a href="/users/edit/' . $row->id . '" class="btn btn-sm btn-primary">Edit</a>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">Delete</button>';
            })
            ->addColumn('branch', function ($row) {
                return $row->branch->name ?? 'N/A';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}

    public function adduser(AdduserRequest $request){
        
        
        $user = User::create([
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'email' => $request->email,
            'role' => $request->role,
            'phone_number' => $request->phone,
            'address' => $request->address,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'pincode' => $request->pin,
            'branch_id' => $request->branch,
            
        ]);

        return response()->json([
           'status' => true,
                'message' => 'User registered Successfully, Password sent via email', //trans(key: 'lang.key')
                'user' => $user,
            ],200); 
    }
    
    public function destroy(Request $request)
{
   
    $request->validate([
        'id' => 'required|integer|exists:users,id',
    ]);

    
    $user = User::find($request->id);

    if ($user) {
        $user->delete(); 
        return response()->json(['success' => 'User deleted successfully.']);
    } else {
        return response()->json(['error' => 'User not found.'], 404);
    }
}

    public function getCountries()
    {
        $countries = Country::all();
        return view('admin.add-user', compact('countries'));
    }
    
    public function getStates($country_id)
    {
        $states = State::where('country_id', $country_id)->get();
        return response()->json($states);
    }

    public function getCities($state_id)
    {
        $cities = City::where('state_id', $state_id)->get();
        return response()->json($cities);
    }
    public function getBranches($city_id)
    {
        $branches = Branch::where('city_id', $city_id)->get(); 
        return response()->json($branches);
    }
   


    public function eventuser()
    {
        
        $events = Event::with('currency')->get();
       
        return view('admin.user-event', compact('events'));
    }
}

