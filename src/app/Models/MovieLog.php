<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MovieLog
 * @package App\Models
 */
class MovieLog extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'movie_log';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = ['movie_id', 'user_id', 'data', 'message', 'error'];

    public const VALIDATION_RULES = [
        'movie_id' => 'required|min:0',
        'user_id' => 'required|min:0',
        'data' => 'required|min:1|max:1000',
        'message' => 'required|min:0',
        'error' => 'required|min:0',
    ];

    protected const MOVIE_UPDATED_SUCCESS = 'Movie was updated with success.';
    protected const MOVIE_UPDATED_ERROR = 'An error ocurred while was trying to save the movie.';

    /**
     * @return string
     */
    public function getUpdatedSuccessMessage(): string
    {
        return __(self::MOVIE_UPDATED_SUCCESS);
    }

    /**
     * @param false $errorMsg
     * @return string
     */
    public function getUpdatedErrorMessage($errorMsg = false): string
    {
        $msg = __(self::MOVIE_UPDATED_ERROR);
        $msg = $errorMsg ?? $msg . ' ' . $errorMsg;

        return $msg;
    }
}
