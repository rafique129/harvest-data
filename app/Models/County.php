<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    use HasFactory;

    public function crop_code_with_weights()
    {
        return $this->hasMany(CropCodeWithWeight::class);
    }
}
