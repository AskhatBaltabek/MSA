<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static insert(array $res)
 */
class CarModel extends Model
{
    use HasFactory;

    protected $fillable = ['*'];
}
