<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function () {
    Route::get('/', \App\Http\Livewire\Guest\Home\Welcome::class)->name('home');
    //next-slot-guest
});
