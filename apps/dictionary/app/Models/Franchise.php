<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static insert(array|$franchises)
 * @method static create(string[] $value)
 * @method static find(string $id)
 * @method static firstWhere(string[] $array)
 */
class Franchise extends BaseModel
{
    use HasFactory;

    public $timestamps = FALSE;
    protected $guarded = ['id'];

    public $fillable = ['agent_commission', 'damage_title', 'damage_coef', 'damage_min_sum', 'loss_title', 'loss_coef', 'loss_min_sum', 'kasko_without_amortization_coef',
        'kasko_with_amortization_coef', 'grand_kasko_amortization_coef'];
    public $readOnlyFields = ['id'];

    public $labels = [
        'id' => 'ID',
        'agent_commission' => 'Агентское вознаграждение',
        'damage_title' => 'Франшиза по повреждению',
        'damage_coef' => 'Коэффициент по повреждению',
        'damage_min_sum' => 'Мин сумма по повреждению',
        'loss_title' => 'Франшиза по утрате',
        'loss_coef' => 'Коэффициент по утрате',
        'loss_min_sum' => 'Мин сумма по утрате',
        'kasko_without_amortization_coef' => 'Каско (без амортизации)',
        'kasko_with_amortization_coef' => 'Каско (с амортизацией)',
        'grand_kasko_amortization_coef' => 'Гранд Каско',

    ];

}
