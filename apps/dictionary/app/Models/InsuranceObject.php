<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static insert(array $risks)
 * @method static truncate()
 */
class InsuranceObject extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];
}
