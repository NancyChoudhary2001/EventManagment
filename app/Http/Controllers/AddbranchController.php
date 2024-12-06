<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\AdduserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddbranchRequest;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Newbranch;
use App\Models\User;
use App\Models\Branch;


class AddbranchController extends Controller
{
    public function getCountries()
    {
        $countries = Country::all();
        return view('admin.add-branch', compact('countries'));
    }
    
    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)->get();
        return response()->json($states);
    }

    public function getCities($stateId)
    {
        $cities = City::where('state_id', $stateId)->get();
        return response()->json($cities);
    }
    public function addbranch(AddbranchRequest $request){
        
        
        $user = Newbranch::create([
            'name' => $request->name,
            'address' => $request->address,
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'pincode' => $request->pincode,
        ]);

        Branch::create([
            'name' => $request->name,
            'city_id' => $request->city,
        ]);

        return response()->json([
           'status' => true,
                'message' => 'User registered Successfully, Password sent via email', //trans(key: 'lang.key')
                'user' => $user,
            ],200); 
    }
    public function newbranch()
    {
        return view('admin.branch');
    }
    public function getBranch(Request $request)
{
    
    $branches = Newbranch::with(['country', 'state', 'city'])->get();  

    return DataTables::of($branches)
        ->addColumn('action', function ($row) {
            return '<a href="/branches/edit/' . $row->name . '" class="btn btn-sm btn-primary">Edit</a>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->name . '">Delete</button>';
        })
        ->addColumn('country', function ($row) {
            return $row->country->name ?? 'N/A'; 
        })
        ->addColumn('state', function ($row) {
            return $row->state->name ?? 'N/A'; 
        })
        ->addColumn('city', function ($row) {
            return $row->city->name ?? 'N/A'; 
        })
        ->rawColumns(['action'])
        ->make(true);
}

public function destroyByName($name)
{
    
    $branch = Newbranch::where('name', $name)->first();

    if (!$branch) {
        return response()->json(['error' => 'Branch not found in Newbranch table'], 404);
    }

    try {
       
        $branch->delete();

       
        $deletedFromBranches = DB::table('branches')->where('name', $name)->delete();

        
        if ($deletedFromBranches) {
            return response()->json(['success' => 'Branch deleted successfully from both tables'], 200);
        } else {
            return response()->json(['error' => 'Branch not found in branches table or not deleted'], 500);
        }
    } catch (\Exception $e) {
       
        return response()->json(['error' => 'Error deleting branch: ' . $e->getMessage()], 500);
    }
}

public function editBranch($name)
{
    $branch = Newbranch::where('name', $name)->first();

    $countries = Country::all();
    $states = State::where('country_id', $branch->country_id)->get();
    $cities = City::where('state_id', $branch->state_id)->get();
    // dd($countries,$states,$cities);

    return view('admin.edit-branch', compact('branch', 'countries', 'states', 'cities'));
}

public function updateBranch(Request $request, $name)
{
   
    $request->validate([
        'name' => 'required|string|unique:newbranches,name,' . $name . ',name', 
        'address' => 'required|string',
        'country' => 'required',
        'state' => 'required',
        'city' => 'required',
        'pincode' => 'required',
    ]);

    
    $branch = Newbranch::where('name', $name)->first();

    
    if (!$branch) {
        return redirect()->route('branch')->with('error', 'Branch not found.');
    }

    
    $originalName = $branch->name;

    
    $branchUpdated = $branch->update([
        'name' => $request->name,
        'address' => $request->address,
        'country_id' => $request->country,
        'state_id' => $request->state,
        'city_id' => $request->city,
        'pincode' => $request->pincode,
    ]);

    
    if ($branchUpdated) {
       
        $branchUpdate = Branch::where('name', $originalName)->update([
            'name' => $request->name,  
            'city_id' => $request->city,
        ]);

       
        if ($branchUpdate) {
            return redirect()->route('branch')->with('success', 'Branch updated successfully.');
        } else {
           
            return redirect()->route('branch')->with('error', 'Failed to update branch in branches table.');
        }
    } else {
        
        return redirect()->route('branch')->with('error', 'Failed to update branch in newbranches table.');
    }
}



}
