<?php

namespace App\Http\Livewire\Guest\Account;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class ForgotPassword extends Component
{
    public $email,$success = false;

    protected $rules = [
        'email' => 'required',
    ];
    public function mount()
    {

    }

    public function sendResetLink()
    {
        $this->validate();
        $user = User::where('email',$this->email)->first();
        if(!$user){
            $this->addError('email','We have not found record you given email');
        }else{
        $size = rand(1111,9999);
        $secret = Hash::make($size);
        $user->secret_hash = $secret;
        $user->save();
        $user->dispatchPasswordResetNotification($secret);
        $this->success = true;
        }

    }

    public function render()
    {
        return view('livewire.guest.account.forgot-password');
    }
}
