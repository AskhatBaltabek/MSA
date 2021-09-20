<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static create(array $array)
 */
class Program extends BaseModel
{
    use HasFactory;

    public $timestamps = FALSE;
    protected $guarded = ['id'];

    public function countries()
    {
        return $this->hasMany(Country::class);
    }

    public function tariffs()
    {
        return $this->hasMany(Tariff::class);
    }
}
