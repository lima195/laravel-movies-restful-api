<?php

namespace App\Exceptions;

use Exception;

/**
 * Class DataNotFoundException
 * @package App\Exceptions
 */
class DataNotFoundException extends Exception
{
    protected const MESSAGE = "The request for %s not found. :/";

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error' => sprintf(self::MESSAGE, $this->getMessage())], 404);
    }
}
