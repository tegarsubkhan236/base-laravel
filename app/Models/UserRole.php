<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRole
 * 
 * @property int $id
 * @property int $user_id
 * @property int $role_id
 * 
 * @property User $user
 * @property Role $role
 *
 * @package App\Models
 */
class UserRole extends Model
{
	protected $table = 'user_roles';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'role_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'role_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function role()
	{
		return $this->belongsTo(Role::class);
	}
}
