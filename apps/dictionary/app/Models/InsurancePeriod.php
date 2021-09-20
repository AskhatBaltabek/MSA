<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static insert(array[] $periods)
 * @method static create($value)
 * @method static find($id)
 */
class InsurancePeriod extends BaseModel
{
    use HasFactory;

    public $timestamps = FALSE;
}
