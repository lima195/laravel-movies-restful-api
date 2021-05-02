<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MovieLike
 * @package App\Models
 */
class MovieLike extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'movie_like';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = ['movie_id', 'user_id'];

    public const VALIDATION_RULES = [
        'movie_id' => 'required|min:0',
        'user_id' => 'required|min:0',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
