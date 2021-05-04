<?php

namespace App\Exceptions;

use Exception;

/**
 * Class MovieAlreadyPaidException
 * @package App\Exceptions
 */
class MovieAlreadyPaidException extends Exception
{
    protected const MESSAGE = "Movie already paid";

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error' => self::MESSAGE], 500);
    }
}
