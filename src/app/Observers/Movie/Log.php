<?php
declare(strict_types=1);

namespace App\Observers\Movie;

use App\Models\Movie;
use App\Models\MovieActivity;

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

    /**
     * @param MovieActivity $movieActivity
     * @param string $message
     * @param int $error
     */
    protected function logMovieActivity(MovieActivity $movieActivity, string $message): void
    {
        $data['title'] = $movieActivity->movie->title;

        if ($movieActivity->type == $movieActivity::RENT) {
            if ($movieActivity->concluded == $movieActivity::UNCONCLUDED) {
                $data['pending_value'] = $movieActivity->rental_price;
                $data['paid_value'] = $movieActivity->paid;
            } else {
                $data['pending_value'] = 0;
                $data['paid_value'] = $movieActivity->paid;
            }
        } else {
            $data['pending_value'] = 0;
            $data['paid_value'] = $movieActivity->paid;
        }

        $logData = [
            'user_id' => auth('api')->user()->id,
            'movie_id' => $movieActivity->id,
            'data' => serialize($data),
            'message' => $message,
            'error' => 0
        ];

        $this->movieLogRepository->create($logData);
    }
}
