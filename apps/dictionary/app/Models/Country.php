<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static create(array $array)
 * @method static find($id)
 */
class Country extends BaseModel
{
    use HasFactory;

    public $timestamps = true;
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
