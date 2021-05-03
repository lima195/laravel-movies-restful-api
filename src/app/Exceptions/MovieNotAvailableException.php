<?php

namespace App\Exceptions;

use Exception;

/**
 * Class InsufficientMoneyException
 * @package App\Exceptions
 */
class MovieNotAvailableException extends Exception
{
    protected const MESSAGE = "Movie not available.";

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error' => __(self::MESSAGE)], 500);
    }
}
