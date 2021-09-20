<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(mixed $value)
 * @method static find(mixed $id)
 */
class PolicyStatus extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ['id'];
}
