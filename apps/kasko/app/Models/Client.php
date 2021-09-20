<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed fio
 * @property mixed iin
 * @property mixed address
 * @property mixed last_name
 * @property mixed first_name
 * @property mixed|null middle_name
 * @property mixed policy_id
 * @property mixed born
 * @property mixed phone
 * @property mixed document_gived_by
 * @property mixed resident_bool
 * @property mixed natural_person_bool
 * @property mixed document_gived_date
 * @property mixed document_number
 * @property mixed document_type_id
 * @property string email
 */
class Client extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function __construct()
    {
    }

    protected $casts = [
        'document_gived_date' => 'date'
    ];


    /**
     * @param array $data
     * @return $this
     */
    public function setData($data = []): Client
    {
        $data = array_change_key_case($data, CASE_LOWER);

        $this->policy_id = $data['policy_id'] ?? $this->policy_id;
        $this->fio = $data['fio'] ?? $this->fio;
        $this->iin = $data['iin'] ?? $this->iin;
        $this->address = $data['address'] ?? $this->address;
        $this->email = $data['email'] ?? $this->email;
        $this->last_name = $data['last_name'] ?? $this->last_name ?? explode(' ', $data['fio'])[0];
        $this->first_name = $data['first_name'] ?? $this->first_name ?? explode(' ', $data['fio'])[1];
        $this->middle_name = $data['middle_name'] ?? $this->middle_name;
        $this->born = $data['born'] ?? $this->born;
        $this->phone = $data['mobile_phone'] ?? $data['phone'] ?? $this->phone;
        $this->document_gived_by = $data['document_gived_by'] ?? $this->document_gived_by;
        $this->document_gived_date = $data['document_gived_date'] ?? $this->document_gived_date;
        $this->document_number = $data['document_number'] ?? $this->document_number;
        $this->document_type_id = $data['document_type_id'] ?? $this->document_type_id;
        $this->natural_person_bool = $data['natural_person_bool'] ?? $this->natural_person_bool ?? 1;
        $this->resident_bool = $data['resident_bool'] ?? $this->resident_bool ?? 1;

        return $this;
    }

    public function getDocumentGivedDateAttribute()
    {
        return date('d.m.Y', strtotime($this->attributes['document_gived_date']));
    }

    /**
     * @return string
     */
    public function getFioTitleAttribute(): string
    {
        return $this->last_name . " " . mb_substr($this->first_name, 0, 1) . "." . ($this->middle_name ? " " .mb_substr($this->middle_name, 0, 1) . "." : "");
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        foreach ($this->getMutatedAttributes() as $key)
        {
            if (!array_key_exists($key, $array)) {
                $array[$key] = $this->{$key};
            }
        }
        return $array;
    }
}
