<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property array $fillable
 * @method static insert(array $data)
 */
class Role extends BaseModel
{
    use HasFactory;

    public $fillable = ['title'];
    public $labels = [
        'id' => 'ID',
        'title' => 'Название роля',
    ];
    public $readOnlyFields = ['id'];
    public $hidden = ['pivot'];

    public function users() {
        return $this->belongsToMany(User::class, 'users_roles');
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'permissions_roles');
    }

    public function rules() {
        return [
            'title' => 'required'
        ];
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($role) { // before delete() method call this
            $role->users()->detach();
            $role->permissions()->detach();
            // do the rest of the cleanup...
        });
    }
}
