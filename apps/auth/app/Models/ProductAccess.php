<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static insert(array $accesses)
 * @method static truncate()
 */
class ProductAccess extends Model
{
    use HasFactory;

    protected $table = 'user_products_access';
}
