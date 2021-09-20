<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static insert($terr)
 * @method static firstWhere(string $string, string $title)
 * @method static create(string[] $value)
 */
class InsuranceTerritory extends BaseModel
{
    use HasFactory;

    public $timestamps = FALSE;
}
