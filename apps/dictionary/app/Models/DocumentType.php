<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static create(array $array)
 */
class DocumentType extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'esbd_id'];
    protected $hidden = ['created_at', 'updated_at'];
}
