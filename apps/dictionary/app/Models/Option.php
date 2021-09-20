<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static insert(array[] $options)
 */
class Option extends BaseModel
{
    use HasFactory;

    public $timestamps = FALSE;
}
