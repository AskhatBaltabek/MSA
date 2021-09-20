<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static insert(array[] $installments)
 * @method static truncate()
 * @method static find($id)
 * @method static create(array $i)
 */
class Installment extends BaseModel
{
    use HasFactory;

    public $timestamps = FALSE;
}
