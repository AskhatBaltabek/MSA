<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static insert(array $risks)
 */
class InsuranceRisk extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];
}
