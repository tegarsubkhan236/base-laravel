<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterStock
 *
 * @property int $id
 * @property int $item_id
 * @property int $qty
 * @property int $sell_price
 * @property int $min_stock
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property MasterItem $master_item
 * @property Collection|SellTransactionDetail[] $sell_transaction_details
 *
 * @package App\Models
 */
class MasterStock extends Model
{
	protected $table = 'master_stocks';

	protected $casts = [
		'item_id' => 'int',
		'qty' => 'int',
		'sell_price' => 'int',
		'min_stock' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'item_id',
		'qty',
		'sell_price',
		'min_stock',
		'status'
	];

	public function master_item()
	{
		return $this->belongsTo(MasterItem::class, 'item_id');
	}

	public function sell_transaction_details()
	{
		return $this->hasMany(SellTransactionDetail::class, 'stock_id');
	}
}
