<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SellTransaction
 * 
 * @property int $id
 * @property int $user_id
 * @property int $status
 * @property string|null $note
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|SellTransactionDetail[] $sell_transaction_details
 *
 * @package App\Models
 */
class SellTransaction extends Model
{
	protected $table = 'sell_transactions';

	protected $casts = [
		'user_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'user_id',
		'status',
		'note'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function sell_transaction_details()
	{
		return $this->hasMany(SellTransactionDetail::class, 'transaction_id');
	}
}
