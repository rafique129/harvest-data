<?php

namespace App\Http\Livewire\Guest\Account;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    public $email,$password,$confirm_password;
    protected $rules = [
        'email' => 'required',
        'password' => 'required|same:confirm_password'
    ];


    public function attemptRegister()
    {
        $this->validate();
        $user = new User();
        $user->email = $this->email;
        $user->makeHashPassword($this->password);
        $user->save();
        Auth::login($user);
        return redirect()->route('auth.cms.show-harvest-data');

    }

    public function render()
    {
        return view('livewire.guest.account.register');
    }
}
