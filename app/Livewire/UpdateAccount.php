<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\State;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class UpdateAccount extends Component


{

    public $name;
    public $email;
    public $phone;
    public $address;
    public $city;
    public $state_id;
    public $country_id;
    public $zip;

    public $country;
    public $timezone;

    public function rules(){
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', Rule::unique('users')->ignore(auth()->id()), 'string', 'email:rfc', 'max:255'],
            'phone' => ['required', 'regex:/^\d{3}-\d{3}-\d{4}$/'],
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state_id' => 'required|integer',
            'country_id' => 'required|integer',
            'timezone' => 'required|string',
            'zip' => ['required', 'string', 'digits:5'],
        ];
    }
    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
        $this->phone = auth()->user()->phone;
        $this->address = auth()->user()->address;
        $this->city = auth()->user()->city;
        $this->state_id = auth()->user()->state_id;
        $this->country_id = auth()->user()->country_id;
        $this->timezone = auth()->user()->timezone;
        $this->zip = auth()->user()->zip;

        $this->country = Country::find($this->country_id);

    }
    #[Computed]
    public function updatedCountryId()
    {
        $this->country = Country::find($this->country_id);
    }
    #[Computed]
    public function timezones()
    {
        return \DateTimeZone::listIdentifiers(
            timezoneGroup: \DateTimeZone::PER_COUNTRY,
            countryCode:  $this->country->code
        );
    }


    public function update()
    {
        $this->validate();

        $user = auth()->user();

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state_id' => $this->state_id,
            'country_id' => $this->country_id,
            'timezone' => $this->timezone,
            'zip' => $this->zip,
        ]);

        session()->flash('success', 'Account updated successfully');

    }
    public function render()
    {
        $states = State::all();
        $countries = Country::all();

        $defaultAvatars = ['cow.png', 'pig.png', 'sheep.png', 'tools.png'];

        return view('livewire.update-account', [
            'states' => $states,
            'countries' => $countries,

        ]);
    }
}
