<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Check if user has been approved, show error view with a note to wait for approval

        if(auth()->user()->approved == false){
            Auth::logout();
            return view('auth.wait');
        }
        return view('user.dashboard');
    }

    public function account()
    {
        $states = State::all();
        $countries = Country::all();

        $defaultAvatars = ['cow.png','pig.png','sheep.png','tools.png'];
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
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
