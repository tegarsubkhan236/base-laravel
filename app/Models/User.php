<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as Authenticate;
use Illuminate\Auth\Authenticatable as AuthenticateTrait;
use Illuminate\Support\Facades\Auth;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string|null $email
 * @property string $password
 * @property string|null $avatar
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Stock[] $stocks
 * @property Collection|Role[] $roles
 *
 * @package App\Models
 */
class User extends Model implements Authenticate
{
    use AuthenticateTrait;

	protected $table = 'users';

	protected $casts = [
		'status' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'name',
		'username',
		'email',
		'password',
		'avatar',
		'status'
	];

	public function stocks()
	{
		return $this->hasMany(Stock::class, 'created_by');
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'user_roles')
					->withPivot('id');
	}

    public function adminlte_image()
    {
        return Auth::user()->avatar ?: 'https://via.placeholder.com/50';
    }
}
