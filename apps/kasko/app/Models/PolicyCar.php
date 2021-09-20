<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed policy_id
 * @property mixed model
 * @property mixed mark
 * @property string number
 * @property mixed born
 * @property mixed insurance_sum
 * @property int premium
 * @property mixed color
 * @property mixed engine_number
 * @property mixed tf_id_esbd
 * @property mixed vin
 * @property mixed registration_region_id
 * @property mixed passport_date
 * @property mixed passport_number
 * @property mixed mark_id
 * @property mixed model_id
 * @property mixed cost
 * @property mixed is_bu
 * @property mixed additional_list
 * @property mixed additional_sum
 */
class PolicyCar extends Model
{
    use HasFactory;

    public function __construct()
    {
    }

    public function setData($data = [])
    {
        $data = array_change_key_case($data, CASE_LOWER);

        $this->policy_id = $data['policy_id'] ?? $this->policy_id;
        $this->mark = $data['mark'] ?? $this->mark;
        $this->model = $data['model'] ?? $this->model;
        $this->mark_id = $data['mark_id'] ?? $this->mark_id;
        $this->model_id = $data['model_id'] ?? $this->model_id;
        $this->born = $data['nyear'] ?? $this->born;
        $this->number = strtoupper($data['number']) ?? $this->number;
        $this->insurance_sum = $data['insurance_sum'] ?? $this->insurance_sum;
        $this->premium = $data['premium'] ?? $this->premium;
        $this->tf_id_esbd = $data['id'] ?? $this->tf_id_esbd;
        $this->color = $data['color'] ?? $this->color;
        $this->vin = $data['vin'] ?? $this->vin;
        $this->cost = $data['cost'] ?? $this->cost;
        $this->is_bu = $data['is_bu'] ?? $this->is_bu;
        $this->registration_region_id = $data['region_id'] ?? $this->registration_region_id;
        $this->passport_number = $data['reg_cert_num'] ?? $this->passport_number;
        $this->passport_date = $data['dt_reg_cert'] ?? $this->passport_date;
        $this->engine_number = $data['engine_number'] ?? $this->engine_number;
        $this->additional_list = $data['additional_list'] ?? $this->additional_list;
        $this->additional_sum = $data['additional_sum'] ?? $this->additional_sum;

        return $this;
    }
}
