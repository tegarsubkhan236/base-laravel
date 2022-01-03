<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Stock
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $sector
 * @property string $sub_sector
 * @property string $summary
 * @property string|null $avatar
 * @property int $netIncome
 * @property float $profitMargin
 * @property float $operationMargin
 * @property float $returnOnAsset
 * @property float $returnOnEquity
 * @property int $marketCap
 * @property int $outstandingShare
 * @property int $actualPrice
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $created_by
 *
 * @property User $user
 *
 * @package App\Models
 */
class Stock extends Model
{
	protected $table = 'stocks';

	protected $casts = [
		'netIncome' => 'int',
		'profitMargin' => 'float',
		'operationMargin' => 'float',
		'returnOnAsset' => 'float',
		'returnOnEquity' => 'float',
		'marketCap' => 'int',
		'outstandingShare' => 'int',
		'actualPrice' => 'int',
		'created_by' => 'int'
	];

	protected $fillable = [
		'code',
		'name',
		'sector',
		'sub_sector',
		'summary',
		'avatar',
		'netIncome',
		'profitMargin',
		'operationMargin',
		'returnOnAsset',
		'returnOnEquity',
		'marketCap',
		'outstandingShare',
		'actualPrice',
		'created_by'
	];

    public function getPER()
    {
        return $this->actualPrice/($this->netIncome/$this->outstandingShare);
    }

	public function user(): BelongsTo
    {
		return $this->belongsTo(User::class, 'created_by');
	}
}
