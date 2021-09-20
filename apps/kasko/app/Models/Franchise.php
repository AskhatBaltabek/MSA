<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $value)
 * @method static where(string $string, $code)
 * @method static find($tarif_id_1c)
 */
class Franchise extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ['id'];
}
