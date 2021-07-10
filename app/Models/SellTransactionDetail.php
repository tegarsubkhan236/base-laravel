<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SellTransactionDetail
 * 
 * @property int $id
 * @property int $transaction_id
 * @property int $stock_id
 * @property int $qty
 * @property Carbon|null $created_at
 * @property Carbon $updated_at
 * 
 * @property MasterStock $master_stock
 * @property SellTransaction $sell_transaction
 *
 * @package App\Models
 */
class SellTransactionDetail extends Model
{
	protected $table = 'sell_transaction_details';

	protected $casts = [
		'transaction_id' => 'int',
		'stock_id' => 'int',
		'qty' => 'int'
	];

	protected $fillable = [
		'transaction_id',
		'stock_id',
		'qty'
	];

	public function master_stock()
	{
		return $this->belongsTo(MasterStock::class, 'stock_id');
	}

	public function sell_transaction()
	{
		return $this->belongsTo(SellTransaction::class, 'transaction_id');
	}
}
