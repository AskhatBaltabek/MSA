<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    const MODELS = [
        'policies' => Policy::class,
    ];


    public function findBy($field, $value)
    {
        return $this->where($field, $value)->first();
    }
}
