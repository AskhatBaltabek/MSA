<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static insert(array $defaults)
 */
class ProductDefault extends BaseModel
{
    use HasFactory;

    protected $table = 'products_defaults';
    protected $guarded = ['id'];
}
