<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class UserprofileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.user-profile', compact('user'));
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|digits:10', 
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
    
        
        $user = Auth::user();
    
        
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
    
        
        if (isset($validated['phone'])) {
            $user->phone_number = $validated['phone'];
        }
    
       
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::delete('public/' . $user->profile_picture);
            }
    
           
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }
    
        
        $user->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Profile Updated successfully!',
        ], 200);
    }



public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => ['required'],
        'new_password' => ['required', 'min:8'], 
        'confirm_password' => 'required|same:new_password', 
    ]);

    $user = Auth::user();

    
    if (!password_verify($request->current_password, $user->password)) {
        return response()->json([
            'errors' => ['current_password' => ['The current password is incorrect.']],
        ], 422);
    }

    
    $user->password = $request->new_password; 
    $user->save();

    return response()->json(['message' => 'Password updated successfully.'], 200);
}

    public function signout(Request $request){

        Auth::logout();
        return redirect()->route('eventuser');
    }

    public function userEvents()
    {
        
        $user = Auth::user();
       
        $userEvents = Item::with('event')  
            ->where('user_id', $user->id)   
            ->get();                        
        
        return view('admin.event-purchased', compact('userEvents'));
    }
}
