<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TestCrud
 *
 * @property int $id
 * @property string|null $test_name
 * @property string|null $test_desc
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TestCrud extends Model
{
    use HasFactory;

	protected $table = 'test_crud';

	protected $fillable = [
		'test_name',
		'test_desc'
	];
}
