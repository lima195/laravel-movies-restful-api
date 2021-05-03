<?php
declare(strict_types=1);

namespace App\Observers;

use App\Models\MovieActivity;
use App\Repository\MovieLogRepositoryInterface;
use App\Observers\Movie\Log;

class MovieActivityObserver
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
     * @param MovieActivity $movieActivity
     */
    public function created(MovieActivity $movieActivity): void
    {
        $userName = $movieActivity->user->name;
        $type = $movieActivity->type === $movieActivity::RENT ? __('rent') : __('bought');
        $movieTitle = $movieActivity->movie->title;
        $message = sprintf(__("User: %s %s a movie: %s"), $userName, $type, $movieTitle);

        $this->logMovieActivity($movieActivity, $message);
    }

    /**
     * @param MovieActivity $movieActivity
     */
    public function updated(MovieActivity $movieActivity): void
    {
        $userName = $movieActivity->user->name;
        $type = $movieActivity->type === $movieActivity::RENT ? __('rent') : __('bought');
        $movieTitle = $movieActivity->movie->title;
        $message = sprintf(__("User: %s paid a %s of movie: %s"), $userName, $type, $movieTitle);

        $this->logMovieActivity($movieActivity, $message);
    }
}
