<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 * @method static truncate()
 * @method static insert(array $data)
 */
class CarMark extends Model
{
    use HasFactory;

    protected $fillable = ['*'];
}
