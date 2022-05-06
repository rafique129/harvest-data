<?php

namespace App\Http\Livewire\Auth\Cms;

use App\Models\County;
use Livewire\Component;
use App\Models\HarvestData;
use Livewire\WithFileUploads;
use App\Models\CropCodeWithWeight;

class ImportHarvestData extends Component
{
    use WithFileUploads;

    public $file;

    protected $rules = [
        'file' => 'required'
    ];
    public function updated()
    {
        $this->validate();
        if ($this->file) {
            $real_path = $this->file->getRealPath();
            $data = [];
            if (($open = fopen($real_path, "r")) !== FALSE) {
                while (($record = fgetcsv($open, 1000, ",")) !== FALSE) {
                    array_push($data, $record);
                }
                fclose($open);
            }
            // dd($data);
            $even = [];
            $odd = [];

            foreach ($data as $key =>  $stack) {
                $county  = new County();
                $county->user_id = auth()->user()->id;
                $county->name = $stack[0];
                $county->save();


                    foreach(array_slice($stack,1) as $key => $val){

                            if($key % 2 == 0){
                                array_push($even,$val);
                            }else{
                                 array_push($odd,$val);
                            }




                }
                // dd($even,$odd);
                if(count($even) == count($odd)){
                    $records = array_combine($even,$odd);
                    $compareCode = [
                        ' W' => 'Wheat' ,
                        ' C' => 'Carrot',
                        ' B' => 'Barley',
                        ' M' => 'Maize',
                        ' BE' => 'Beetroot',
                        ' PO' => 'Potatoes',
                        ' PA' => 'Parsnips',
                        ' O' => 'Oats'
                    ];
                    foreach($records as $key => $val){

                        $isValid = array_key_exists($key,$compareCode);

                        if($isValid){
                            $crop_code_with_weight = new CropCodeWithWeight();
                            $crop_code_with_weight->county_id = $county->id;
                                $crop_code_with_weight->crop_code = $key;
                                $crop_code_with_weight->weight = $val;
                                $crop_code_with_weight->save();
                        }

                    }
                    $even = [];
                    $odd = [];
                    $this->emit('csvImported');
                }else{
                    $this->addError('error', 'Some records are missing');
                }

            }
        }
    }

    public function render()
    {
        return view('livewire.auth.cms.import-harvest-data');
    }
}
