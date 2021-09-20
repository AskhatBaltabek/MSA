<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static create(array $array)
 */
class Region extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];
}
