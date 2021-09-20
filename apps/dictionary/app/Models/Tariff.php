<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static create(array $array)
 */
class Tariff extends BaseModel
{
    use HasFactory;

    public $timestamps = true;
    protected $guarded = ['id'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
