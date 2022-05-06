<?php

use Illuminate\Support\Facades\Route;

Route::prefix('cms')->group(function () {
    Route::middleware(['auth'])->group(function () {
         Route::get('dashboard', \App\Http\Livewire\Auth\Cms\Dashboard::class)->name('auth.cms.dashboard');
        Route::get('show-harvest-data', \App\Http\Livewire\Auth\Cms\ShowHarvestData::class)->name('auth.cms.show-harvest-data');
        Route::get('import-harvest-data', \App\Http\Livewire\Auth\Cms\ImportHarvestData::class)->name('auth.cms.import-harvest-data');
        //next-slot-auth
});
});
