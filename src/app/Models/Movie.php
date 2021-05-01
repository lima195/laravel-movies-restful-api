<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Movie
 * @package App\Models
 */
class Movie extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'movie';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = ['title', 'description', 'stock', 'rental_price', 'sale_price', 'availability'];

    public const DEFAULT_POSITIVE_AVAILABILITY = true;
    public const DEFAULT_NEGATIVE_AVAILABILITY = false;

    public const VALIDATION_RULES = [
        'title' => 'required|max:255',
        'description' => 'required|min:20|max:255',
        'stock' => 'required|numeric|max:999999999',
        'rental_price' => 'required|numeric|max:999999.99',
        'sale_price' => 'required|numeric|max:999999.99',
        'availability' => 'numeric|min:0|max:1'
    ];

    public const EXTRA_VALIDATION_RULES = [
        'availability' => 'required|numeric|min:0|max:1'
    ];
}
