<?php

namespace App\Http\Livewire\Guest\Account;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Component
{
    public $email,$password,$confirm_password;

    protected $rules = [
        'email' => 'required',
        'password' => 'required|same:confirm_password'
    ];
    public function mount($email,$secret)
    {
        $user = User::where('email', $email)->first();
        if(!$user){
            abort(404);
        }else{
            $isValid = Hash::check($secret,$user->secret_hash);
            if($isValid){
                $this->email = $user->email;
            }
        }

    }

    public function attemptResetPassword()
    {
        $user = User::where('email', $this->email)->first();
        $user->makeHashPassword($this->password);
        $user->save();
        return redirect()->route('guest.account.login');
    }

    public function render()
    {
        return view('livewire.guest.account.reset-password');
    }
}
