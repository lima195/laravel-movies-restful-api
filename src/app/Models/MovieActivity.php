<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class MovieActivity
 * @package App\Models
 */
class MovieActivity extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'movie_activity';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = ['movie_id', 'user_id', 'concluded', 'penalty', 'paid', 'type'];

    public const VALIDATION_RULES = [
        'movie_id' => 'required|min:0',
        'user_id' => 'required|min:0',
        'concluded' => 'required|min:0',
        'penalty' => 'required|min:0',
        'paid' => 'required|min:0',
        'type' => 'required|string',
    ];

    public const PURCHASE = 0;
    public const RENT = 1;
    public const PENALTY_NONE = 0;
    public const PENALTY_A_DAY = 10;
    public const UNCONCLUDED = 0;
    public const CONCLUDED = 1;
    public const MIN_DAYS_WITHOUT_PENALTY = 7;

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

    /**
     * @return float|int
     */
    public function getPenalty(): float
    {
        $penalty = 0;
        $current = Carbon::now();
        $rentDate = new Carbon($this->created_at);
        $rentDate = $rentDate->addDays(self::MIN_DAYS_WITHOUT_PENALTY);

        if ($current->diffInDays($rentDate) > 0) {
            $penalty = self::PENALTY_A_DAY * $current->diffInDays($rentDate);
        }

        return $penalty;
    }
}
