<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $array)
 * @method static insert(array $products)
 * @method static truncate()
 * @method static where($field, $value)
 */
class Product extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $hidden = ['pivot'];

    public function objects()
    {
        return $this->belongsToMany(InsuranceObject::class, 'products_relations', 'product_id_1c', 'insurance_object_id_1c', 'id_1c', 'id_1c');
    }

    public function printTemplates()
    {
        return $this->hasMany(PrintTemplate::class);
    }

    public function insuranceRisks()
    {
        return $this->belongsToMany(InsuranceRisk::class, 'products_relations', 'product_id_1c', 'insurance_risk_id_1c', 'id_1c', 'id_1c');
    }

    public function insuranceTypes()
    {
        return $this->belongsToMany(InsuranceType::class, 'products_relations', 'product_id_1c', 'insurance_type_id_1c', 'id_1c', 'id_1c');
    }

    public function defaults()
    {
        return $this->hasMany(ProductDefault::class, 'product_id_1c', 'id_1c');
    }

    public function relations()
    {
        return $this->belongsToMany(InsuranceObject::class, 'products_relations', 'product_id_1c', 'insurance_object_id_1c', 'id_1c', 'id_1c')
                ->join('insurance_types', 'insurance_types.id_1c', '=', 'insurance_type_id_1c')
                ->join('insurance_risks', 'insurance_risks.id_1c', '=', 'insurance_risk_id_1c')
                ->select(
                    'insurance_types.id as type_id',
                    'insurance_types.id_1c as type_id_1c',
                    'insurance_types.title as type_title',
                    'insurance_types.serial_number',
                    'insurance_types.obligate as type_obligate',
                    'insurance_types.active as type_active',
                    'insurance_risks.id as risk_id',
                    'insurance_risks.id_1c as risk_id_1c',
                    'insurance_risks.title as risk_title',
                    'insurance_risks.active as risk_active',
                    'insurance_objects.id as object_id',
                    'insurance_objects.id_1c as object_id_1c',
                    'insurance_objects.title as object_title',
                    'insurance_objects.type as object_type',
                    'insurance_objects.active as object_active',
                );
    }

    public function settings()
    {
        return $this->hasMany(ProductSetting::class, 'product_id_1c', 'id_1c');
    }

    public function findBy($field, $value)
    {
        return self::where($field, $value)->first();
    }
}
