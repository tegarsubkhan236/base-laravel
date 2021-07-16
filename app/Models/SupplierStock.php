<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SupplierStock
 *
 * @property int $id
 * @property int $supplier_id
 * @property int $item_id
 * @property int $qty
 * @property int $sell_price
 * @property int $min_stock
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property MasterItem $master_item
 * @property Supplier $supplier
 * @property Collection|BuyTransactionDetail[] $buy_transaction_details
 *
 * @package App\Models
 */
class SupplierStock extends Model
{
	protected $table = 'supplier_stocks';

	protected $casts = [
		'supplier_id' => 'int',
		'item_id' => 'int',
		'qty' => 'int',
		'sell_price' => 'int',
        'min_stock' => 'int',
        'status' => 'int'
	];

	protected $fillable = [
		'supplier_id',
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

	public function supplier()
	{
		return $this->belongsTo(Supplier::class);
	}

	public function buy_transaction_details()
	{
		return $this->hasMany(BuyTransactionDetail::class, 'stock_id');
	}
}
