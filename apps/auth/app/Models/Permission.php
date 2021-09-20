<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends BaseModel
{
    use HasFactory;

    public $fillable = ['title'];

    public function rules() {
        return [
            'title' => 'required'
        ];
    }
}
