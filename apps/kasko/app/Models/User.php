<?php

namespace App\Models;

use App\Services\AuthService;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 *
 * @property int $id
 * @property int $id_1c
 * @property int $id_ext
 * @property string $login
 * @property string $email
 * @property int $manager_id
 * @property int $agent_id
 * @property string $name
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $iin
 * @property string $mobile_phone
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string $filial
 * @property int $filial_id_1c
 * @property string $department
 * @property string $division
 * @property string $position
 * @property string $sales
 * @property bool $resident
 * @property bool $external
 * @property bool $natural_person_bool
 * @property string $document_number
 * @property Carbon|null $document_start_date
 * @property Carbon|null $document_end_date
 * @property string $link_to_branch
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property array $product_accesses
 */

class User extends Model implements AuthenticatableContract
{
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return null;
    }

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value) {}

    public function getRememberTokenName() {}


    public function setData($data)
    {
        foreach($data as $key => $value) {
            $this->{$key} = $value;
        }

        return $this;
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

    /**
     * @throws GuzzleException
     */
    public static function find($id): User
    {
        $data = (new AuthService())->get("/api/users/$id");

        return (new User)->setData($data);
    }

    /**
     * @throws GuzzleException
     */
    public static function findBy($field, $id): User
    {
        $data = (new AuthService())->get("/api/users/$field/$id");

        return (new User)->setData($data);
    }

}
