<?php
declare(strict_types=1);

namespace App\Observers;

use App\Models\Movie;
use App\Repository\MovieLogRepositoryInterface;
use App\Observers\Movie\Log;

class MovieObserver
{
    use Log;

    /**
     * @var MovieLogRepositoryInterface
     */
    private $movieLogRepository;

    /**
     * MovieObserver constructor.
     * @param MovieLogRepositoryInterface $movieLogRepository
     */
    public function __construct(
        MovieLogRepositoryInterface $movieLogRepository
    ) {
        $this->movieLogRepository = $movieLogRepository;
    }

    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * @param Movie $movie
     */
    public function created(Movie $movie): void
    {
        $message = "Create movie";
        $this->logMovie($movie, $message);
    }

    /**
     * @param Movie $movie
     */
    public function updated(Movie $movie): void
    {
        $message = "Update movie";
        $this->logMovie($movie, $message);
    }
}
