<?php
declare(strict_types=1);

namespace App\Observers\Movie;

use App\Models\Movie;

/**
 * Trait Log
 * @package App\Observers\Movie
 */
trait Log
{
    /**
     * @param Movie $movie
     * @param string $message
     * @param int $error
     */
    protected function logMovie(Movie $movie, string $message, int $error = 0): void
    {
        $data = [
            'title' => $movie->title,
            'rental_price' => $movie->rental_price,
            'sale_price' => $movie->sale_price,
        ];

        $logData = [
            'user_id' => auth('api')->user()->id,
            'movie_id' => $movie->id,
            'data' => serialize($data),
            'message' => $message,
            'error' => $error
        ];

        $this->movieLogRepository->create($logData);
    }
}
