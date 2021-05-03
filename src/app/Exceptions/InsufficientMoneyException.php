<?php

namespace App\Exceptions;

use Exception;

/**
 * Class InsufficientMoneyException
 * @package App\Exceptions
 */
class InsufficientMoneyException extends Exception
{
    protected const INSUFFICIENT_MESSAGE = "Insufficient credit. Minimum amount: ";
    protected const YOUR_CREDIT_MESSAGE = "Your credit: ";
    protected $message;

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request): \Illuminate\Http\JsonResponse
    {
        $this->buildMessage($request->credit);
        return response()->json(['error' => $this->message], 500);
    }

    /**
     * @param $credit
     */
    protected function buildMessage($credit): void
    {
        $this->message = __(self::INSUFFICIENT_MESSAGE) . $this->getMessage() . ' ';
        $this->message.= __(self::YOUR_CREDIT_MESSAGE) . $credit;
    }
}
