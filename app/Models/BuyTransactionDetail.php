<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BuyTransactionDetail
 * 
 * @property int $id
 * @property int $transaction_id
 * @property int $stock_id
 * @property int $qty
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property SupplierStock $supplier_stock
 * @property BuyTransaction $buy_transaction
 *
 * @package App\Models
 */
class BuyTransactionDetail extends Model
{
	protected $table = 'buy_transaction_details';

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

	public function supplier_stock()
	{
		return $this->belongsTo(SupplierStock::class, 'stock_id');
	}

	public function buy_transaction()
	{
		return $this->belongsTo(BuyTransaction::class, 'transaction_id');
	}
}
