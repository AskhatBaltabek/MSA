<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @method static where($column, $value)
 * @method static truncate()
 * @method static create(array $array)
 * @method static find($id)
 */
class Setting extends BaseModel
{
    use HasFactory;

    public $timestamps = FALSE;
    protected $guarded = ['id'];
    protected $fillable = ['setting', 'setting->value', 'setting->type', 'setting->active', '*'];


    public function findBy($column, $value)
    {
        try {
            return self::where($column, $value)->firstOrFail();
        } catch(ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    public function logs(): MorphMany
    {
        return $this->morphMany('App\Models\Log', 'loggable');
    }
}
