<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property integer $amount
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @package App\Models
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'description', 'price', 'amount'];
}
