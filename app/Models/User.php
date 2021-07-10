<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Casts\UserLevel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable as Authenticate;
use Illuminate\Auth\Authenticatable as AuthenticateTrait;

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
	    'name',
		'username',
		'password',
		'email',
		'status',
		'avatar'
	];

    protected $with = ['roles'];

	public function roles()
	{
		return $this->belongsToMany(Role::class);
	}

    public function adminlte_image()
    {
        return Auth::user()->avatar ?: 'https://via.placeholder.com/50';
    }

    public function adminlte_desc()
    {
        $id = RoleUser::with('user')->where('user_id',Auth::id())->first();
        return UserLevel::lang($id->role_id);
    }

    public function adminlte_profile_url()
    {
        return route('profile',['user_id'=>Auth::id()]);
    }
}
