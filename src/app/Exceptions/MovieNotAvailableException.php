<?php

namespace App\Exceptions;

use Exception;

/**
 * Class MovieNotAvailableException
 * @package App\Exceptions
 */
class MovieNotAvailableException extends Exception
{
    protected const MESSAGE = "Movie not available.";

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error' => __(self::MESSAGE)], 500);
    }
}
