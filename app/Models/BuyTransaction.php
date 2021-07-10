<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BuyTransaction
 * 
 * @property int $id
 * @property int $user_id
 * @property int $supplier_id
 * @property int $status
 * @property int|null $note
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Supplier $supplier
 * @property Collection|BuyTransactionDetail[] $buy_transaction_details
 *
 * @package App\Models
 */
class BuyTransaction extends Model
{
	protected $table = 'buy_transactions';

	protected $casts = [
		'user_id' => 'int',
		'supplier_id' => 'int',
		'status' => 'int',
		'note' => 'int'
	];

	protected $fillable = [
		'user_id',
		'supplier_id',
		'status',
		'note'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function supplier()
	{
		return $this->belongsTo(Supplier::class);
	}

	public function buy_transaction_details()
	{
		return $this->hasMany(BuyTransactionDetail::class, 'transaction_id');
	}
}
