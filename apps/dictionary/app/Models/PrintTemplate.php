<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(array $array)
 * @method static create(array $value)
 * @method static firstWhere(string $string, $key)
 */
class PrintTemplate extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = FALSE;

    public $fillable = ['key', 'title', 'product_id', 'body_kz', 'body_ru', 'body_en'];
    public $readOnlyFields = ['id'];

    public $labels = [
        'id' => 'ID',
        'product_id' => 'ID продукта',
        'key' => 'Ключ',
        'title' => 'Название',
        'body_kz' => 'Шаблон на казахском',
        'body_ru' => 'Шаблон на русском',
        'body_en' => 'Шаблон на английском',
    ];
}
