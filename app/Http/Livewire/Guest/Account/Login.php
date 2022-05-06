<?php

namespace App\Http\Livewire\Guest\Account;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class Login extends Component
{
    use ThrottlesLogins;
    public $email, $password;

    protected $rules = [
        'email' => 'required',
        'password' => 'required',
    ];

    protected $messages = [
        'email.required' => 'Please provide a valid email address.',
        'password.required' => 'You cannot login without a password'
    ];



    public function attemptLogin()
    {
        $this->validate();

        // Inject email to current login request
        $request = request();
        $request->attributes->set('email', $this->email);

        // This method is defined in ThrottlesLogins. it is used to block user requests if user
        // has too many failed attempts to login to the system.
        $tooManyAttemptes = $this->hasTooManyLoginAttempts($request);
        if ($tooManyAttemptes) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutError();
            return null;
        }

        // Find user matched with the requested email
        $user = User::where('email', $this->email)->first();


        // Terminate login process when user has invalid credentials and send login failed error
        $invalidCredentials = $user == null || $user->failPasswordChallenge($this->password);
        if ($invalidCredentials) {
            $this->incrementLoginAttempts($request);
            $this->sendFailedError();
            return null;
        }

        // User credentails are valid. Login current user and clear the failed attempt counter
        $this->clearLoginAttempts($request);

        Auth::login($user, true);

        // Redirect to dashboard
        return redirect()->route('auth.cms.show-harvest-data');
    }

    public function render()
    {
        return view('livewire.guest.account.login');
    }

    private function sendFailedError()
    {
        $this->addError('email', 'Invalid email or password');
    }

    private function sendLockoutError()
    {
        $this->addError('email', 'You attempted too many times. Please wait for few minutes and try again');
    }

    //This method must be defined here becuase ThrottlesLogins depends on this method to process the request.
    public function username()
    {
        return 'email';
    }
}
