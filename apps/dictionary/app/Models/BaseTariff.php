<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static create(array $array)
 */
class BaseTariff extends BaseModel
{
    use HasFactory;

    public $timestamps = true;
    protected $guarded = ['id'];

    public function country()
    {
        return $this->hasMany(Country::class, 'country_id', 'country_id');
    }
}
