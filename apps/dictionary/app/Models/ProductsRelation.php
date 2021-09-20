<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static insert(array $rel)
 */
class ProductsRelation extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'products_relations';
}
