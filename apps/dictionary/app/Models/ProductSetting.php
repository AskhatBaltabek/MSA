<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static insert(array[] $settings)
 */
class ProductSetting extends BaseModel
{
    use HasFactory;

    public $timestamps = FALSE;
    protected $table = 'products_settings';

    protected $guarded = ['id'];

    public $fillable = ['title', 'value'];
    public $readOnlyFields = ['id'];

    public $labels = [
        'id' => 'ID',
        'title' => 'Название настройки',
        'value' => 'Значение',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id_1c', 'id_1c');
    }
}
