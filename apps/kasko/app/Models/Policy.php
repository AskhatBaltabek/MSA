<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(mixed $policyData)
 * @method static find($policy_id)
 * @method static findOrFail(mixed $id)
 * @method static firstWhere(string $string, mixed $policyNumber)
 * @property mixed policy_number
 * @property mixed status
 * @property mixed payments
 * @property mixed $updated_at
 * @property mixed $ordered_at
 */
class Policy extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 0;
    const STATUS_DONE = 1;
    const EMAIL_KASKO_CODE = 'email-kasko';

    CONST RESCINDING_OPERATOR_MISTAKE = 6;

    protected $guarded = ['id'];

    /**
     * Для выборки записей авторизованного юзера
     * С User->id_1c по Table->user_id_1c
     * IF TRUE только записи юзера
     * IF FALSE все записи
     */
    public $getOwnersRecs = TRUE;

    public $casts = [
        'payments'    => 'array',
        'beneficiary' => 'array',
        'options'     => 'array',
    ];

    /**
     * @return HasOne
     */
    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    /**
     * @return HasOne
     */
    public function car(): HasOne
    {
        return $this->hasOne(PolicyCar::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PolicyStatus::class, 'status', 'id');
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData($data = []): Policy
    {
        foreach ($data as $key => $value) {
            $this[$key] = $value;
        }

        return $this;
    }

    public function reload()
    {
        $instance = new static;
        $instance = $instance->newQuery()->find($this->{$this->primaryKey});
        $this->attributes = $instance->attributes;
        $this->original = $instance->original;
    }

    /**
     * @return bool
     */
    public function validateForRescinding(): bool
    {
        $res = FALSE;

        if(date('Y-m-d', strtotime($this->ordered_at)) === date('Y-m-d'))
        {
            $res = TRUE;
        }

        return $res;
    }
}
