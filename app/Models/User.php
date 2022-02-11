<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\HasPermissionsTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable as Authenticate;
use Illuminate\Auth\Authenticatable as AuthenticateTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Permission[] $permissions
 * @property Collection|Role[] $roles
 *
 * @package App\Models
 */
class User extends Model implements Authenticate
{
    use AuthenticateTrait, HasPermissionsTrait;

	protected $dates = [
		'email_verified_at'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'password',
		'remember_token'
	];

	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'users_permissions');
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'users_roles');
	}
}
