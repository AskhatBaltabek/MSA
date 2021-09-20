<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property array $fillable
 */
class BaseModel extends Model
{
    use HasFactory;

    const MODELS = [
        'users' => User::class,
    ];

    /**
     * BaseModel constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }

    public function getModel($modeName) {
        return $this->models()[$modeName];
    }


    public function models() {
        return [
            'roles' => Role::class,
            'permissions' => Permission::class,
            'users' => User::class,
        ];
    }
}
