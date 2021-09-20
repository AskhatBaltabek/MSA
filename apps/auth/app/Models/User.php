<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @method static firstWhere(string $string, $email)
 * @method static find($id)
 * @method static create(array $array)
 * @method static insert(array $result)
 * @property string last_name
 * @property string first_name
 * @property string middle_name
 * @property string login
 * @property string email
 * @property string department
 * @property Hash password
 * @property bool external
 * @property int id
 * @property array $fillable
 * @property mixed productAccesses
 * @property mixed product_accesses
 * @property string name
 * @property mixed $agents
 * @property mixed $mobile_phone
 * @property mixed $roles
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $guarded = ['id'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $labels = [
        'id'          => 'ID',
        'login'       => 'Логин',
        'password'    => 'Пароль',
        'email'       => 'Email',
        'last_name'   => 'Фамилия',
        'first_name'  => 'Имя',
        'middle_name' => 'Отчество',
        'iin'         => 'ИИН',
    ];

    /**
     * @var string[]
     */
    public $readOnlyFields = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return int
     */
    public function getRoleCountAttribute(): int
    {
        return count($this->roles);
    }

    /**
     * @return mixed|string
     */
    public function getNameAttribute()
    {
        return $this->attributes['name'] ?: ($this->last_name . ' ' . $this->first_name . ' ' . ($this->middle_name ?: ''));
    }

    public function getPhoneAttribute()
    {
        return $this->attributes['phone'] ?: $this->mobile_phone;
    }

    /**
     * @param $data
     * @return bool
     */
    public function createUserFromLdap($data): bool
    {
        $fio               = explode(' ', $data['cn'][0]);
        $this->last_name   = array_key_exists(0, $fio) ? $fio[0] : '';
        $this->first_name  = array_key_exists(1, $fio) ? $fio[1] : '';
        $this->middle_name = array_key_exists(2, $fio) ? $fio[2] : '';
        $this->login       = $data['samaccountname'][0] ?? '';
        $this->email       = $data['mail'][0] ?? '';
        $this->department  = $data['department'][0] ?? '';
        $this->password    = $data['password'];
        return $this->save();
    }

    /**
     * @param $data
     * @return bool
     */
    public function updateUserFromLdap($data): bool
    {
        $fio              = explode(' ', $data['cn'][0]);
        $this->last_name  = $fio[0];
        $this->department = $data['department'][0] ?? '';
        $this->password   = $data['password'];
        return $this->save();
    }

    /**
     * @param $field
     * @param $value
     * @return Builder|Model
     */
    public static function findBy($field, $value)
    {
        return self::with('agents.productAccesses', 'manager', 'productAccesses')->firstWhere($field, $value);
    }

    public function productAccesses(): HasMany
    {
        return $this->hasMany(ProductAccess::class, 'user_id', 'id_1c');
    }

    public function agents(): HasMany
    {
        return $this->hasMany(User::class, 'manager_id', 'id_1c');
    }

    public function manager(): HasOne
    {
        return $this->hasOne(User::class, 'id_1c', 'manager_id');
    }

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * @return int[]
     */
    public function rolesIds(): array
    {
        return $this->roles->pluck('id');
    }

    // this is a recommended way to declare event handlers
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($user) { // before delete() method call this
            $user->roles()->detach();
            // do the rest of the cleanup...
        });
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return int
     */
    public function getJWTIdentifier(): int
    {
        return $this->id;
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
