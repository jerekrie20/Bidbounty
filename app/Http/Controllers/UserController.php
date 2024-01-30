<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Check if user has been approved, show error view with a note to wait for approval

        if (auth()->user()->approved == false) {
            Auth::logout();
            return view('auth.wait');
        }
        return view('user.dashboard');
    }

    public function account()
    {
        $states = State::all();
        $countries = Country::all();

        $defaultAvatars = ['cow.png', 'pig.png', 'sheep.png', 'tools.png'];
        return view('user.account', [
            'user' => auth()->user(),
            'states' => $states,
            'countries' => $countries,
            'defaultAvatars' => $defaultAvatars

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateAccount(User $user)
    {


        //Get data and validate
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', Rule::unique('users')->ignore($user->id), 'string', 'email', 'max:255'],
            'phone' => ['required', 'regex:/^\d{3}-\d{3}-\d{4}$/'],
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state_id' => 'required|integer',
            'country_id' => 'required|integer',
            'zip' => ['required', 'string', 'digits:5'],
        ]);


        //Update user

        $user->update($data);

        //Redirect to account page with success message
        return redirect()->route('account')->with('success', 'Account updated successfully');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
