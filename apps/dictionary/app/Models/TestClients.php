<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static insert(array[] $options)
 */
class TestClients extends BaseModel
{
    use HasFactory;

    public $timestamps = FALSE;
}
