<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersPermission
 * 
 * @property int $user_id
 * @property int $permission_id
 * 
 * @property User $user
 * @property Permission $permission
 *
 * @package App\Models
 */
class UsersPermission extends Model
{
	protected $table = 'users_permissions';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'permission_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'permission_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function permission()
	{
		return $this->belongsTo(Permission::class);
	}
}
