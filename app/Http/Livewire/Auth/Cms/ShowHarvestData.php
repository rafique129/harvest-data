<?php

namespace App\Http\Livewire\Auth\Cms;

use App\Models\County;
use Livewire\Component;
use App\Models\HarvestData;
use Illuminate\Support\Facades\Auth;

class ShowHarvestData extends Component
{
    public $counties;

   protected $listeners  = ['csvImported'];

   public function csvImported()
   {
        $this->loadData();
   }


    public function mount()
    {
        $this->loadData();

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.auth.cms.show-harvest-data');
    }

    public function loadData()
    {
        $this->counties = County::where('user_id',auth()->user()->id)->with('crop_code_with_weights')->orderBy('created_at','desc')->get();

    }
}
