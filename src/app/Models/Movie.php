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

    public const DEFAULT_POSITIVE_AVAILABILITY = true;
    public const DEFAULT_NEGATIVE_AVAILABILITY = false;
}
