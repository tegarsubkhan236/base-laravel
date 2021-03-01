<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable as Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Role[] $roles
 *
 * @package App\Models
 */
class User extends Model implements Authenticatable
{
    use AuthenticatableTrait;

	protected $table = 'users';

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'username',
		'password'
	];

	public function roles()
	{
		return $this->belongsToMany(Role::class);
	}
}
