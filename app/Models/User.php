<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Casts\UserLevel;
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
 * @property string $username
 * @property string $password
 * @property string|null $email
 * @property int $status
 * @property string|null $avatar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
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
		'username',
		'password',
		'email',
		'status',
		'avatar'
	];

	public function roles()
	{
		return $this->belongsToMany(Role::class);
	}

    public function adminlte_image()
    {
        return Auth::user()->avatar?'avatar':'https://picsum.photos/300/300';
    }

    public function adminlte_desc()
    {
        return UserLevel::class;
    }

    public function adminlte_profile_url()
    {
        return 'profile/'.Auth::id();
    }
}
