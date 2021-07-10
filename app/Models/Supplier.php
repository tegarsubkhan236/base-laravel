<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Supplier
 * 
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $phone
 * @property string|null $address
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|BuyTransaction[] $buy_transactions
 * @property Collection|SupplierStock[] $supplier_stocks
 *
 * @package App\Models
 */
class Supplier extends Model
{
	protected $table = 'suppliers';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'name',
		'phone',
		'address'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function buy_transactions()
	{
		return $this->hasMany(BuyTransaction::class);
	}

	public function supplier_stocks()
	{
		return $this->hasMany(SupplierStock::class);
	}
}
