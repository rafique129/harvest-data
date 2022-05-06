<?php

use Illuminate\Support\Facades\Route;

Route::prefix('account')->group(function () {
    Route::middleware(['guest'])->group(function () {
         Route::get('login', \App\Http\Livewire\Guest\Account\Login::class)->name('guest.account.login');
        Route::get('register', \App\Http\Livewire\Guest\Account\Register::class)->name('guest.account.register');
        Route::get('forgot-password', \App\Http\Livewire\Guest\Account\ForgotPassword::class)->name('guest.account.forgot-password');
        Route::get('reset-password/{email}/{secret}', \App\Http\Livewire\Guest\Account\ResetPassword::class)->name('guest.account.reset-password');
        //next-slot-guest
});
});
