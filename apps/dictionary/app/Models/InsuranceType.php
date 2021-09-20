<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static insert(array $types)
 * @method static truncate()
 */
class InsuranceType extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];
}
