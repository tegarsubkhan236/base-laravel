<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ItemCategory
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|MasterItem[] $master_items
 *
 * @package App\Models
 */
class ItemCategory extends Model
{
	protected $table = 'item_categories';

	protected $fillable = [
		'name'
	];

	public function master_items()
	{
		return $this->hasMany(MasterItem::class, 'category_id');
	}
}
