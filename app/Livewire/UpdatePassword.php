<?php

namespace App\Livewire;

use Livewire\Component;

class UpdatePassword extends Component
{

    public $password;
    public $password_confirmation;

    public function rules()
    {
        return [
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function updatePassword()
    {
        $this->validate();
        $user = auth()->user();
        $user->update([
            'password' => bcrypt($this->password),
        ]);

        $this->reset();
        session()->flash('success', 'Password updated successfully');
    }
    public function render()
    {
        return view('livewire.update-password');
    }
}
