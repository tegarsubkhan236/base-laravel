<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterItem
 * 
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property ItemCategory $item_category
 * @property Collection|MasterStock[] $master_stocks
 * @property Collection|SupplierStock[] $supplier_stocks
 *
 * @package App\Models
 */
class MasterItem extends Model
{
	protected $table = 'master_items';

	protected $casts = [
		'category_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'category_id',
		'name',
		'status'
	];

	public function item_category()
	{
		return $this->belongsTo(ItemCategory::class, 'category_id');
	}

	public function master_stocks()
	{
		return $this->hasMany(MasterStock::class, 'item_id');
	}

	public function supplier_stocks()
	{
		return $this->hasMany(SupplierStock::class, 'item_id');
	}
}
