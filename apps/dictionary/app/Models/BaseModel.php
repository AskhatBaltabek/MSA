<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    const MODELS = [
        'products' => Product::class,
        'insurance-objects' => InsuranceObject::class,
        'insurance-types' => InsuranceType::class,
        'insurance-risks' => InsuranceRisk::class,
        'regions' => Region::class,
        'product-settings' => ProductSetting::class,
        'insurance-periods' => InsurancePeriod::class,
        'settings' => Setting::class,
        'countries' => Country::class,
        'programs' => Program::class,
        'currencies' => Currency::class,
        'tariffs' => Tariff::class,
        'product-defaults' => ProductDefault::class,
        'economics-sectors' => EconomicsSector::class,
        'activity-kinds' => ActivityKind::class,
        'print-templates' => PrintTemplate::class,
        'options' => Option::class,
        'franchises' => Franchise::class,
        'kasko-calculates' => KaskoCalculate::class,
        'car-marks' => CarMark::class,
        'car-models' => CarModel::class,
        'esbd-fault-codes' => EsbdFaultCode::class,
        'notification-types' => NotificationType::class,
        'esbd-errors' => EsbdError::class,
        'document-types' => DocumentType::class,
        'base-tariffs' => BaseTariff::class,
        'purpose' => Purpose::class,
        'age-experiences' => AgeExperience::class,
        'vehicle-types' => VehicleType::class
    ];


    public function findBy($field, $value)
    {
        return $this->where($field, $value)->first();
    }
}
