<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RolesPermission
 * 
 * @property int $role_id
 * @property int $permission_id
 * 
 * @property Role $role
 * @property Permission $permission
 *
 * @package App\Models
 */
class RolesPermission extends Model
{
	protected $table = 'roles_permissions';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'role_id' => 'int',
		'permission_id' => 'int'
	];

	protected $fillable = [
		'role_id',
		'permission_id'
	];

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function permission()
	{
		return $this->belongsTo(Permission::class);
	}
}
