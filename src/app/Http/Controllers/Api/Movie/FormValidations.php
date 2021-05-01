<?php

namespace App\Http\Controllers\Api\Movie;

use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Validator;

/**
 * Trait FormValidations
 * @package App\Http\Controllers\Api\Movie
 */
trait FormValidations
{
    /**
     * @param Request $request
     * @return array
     */
    protected function _prepareData(Request $request): array
    {
        Validator::make($request->all(), $this->_validateFieldRules($request))->validate();

        $data = [];

        if ($request->has('title')) {
            $data['title'] = (string)$request->input('title');
        }

        if ($request->has('description')) {
            $data['description'] = (string)$request->input('description');
        }

        if ($request->has('stock')) {
            $data['stock'] = (int)$request->input('stock');
        }

        if ($request->has('rental_price')) {
            $data['rental_price'] = (float)$request->input('rental_price');
        }

        if ($request->has('sale_price')) {
            $data['sale_price'] = (float)$request->input('sale_price');
        }

        if ($request->has('availability')) {
            $data['availability'] = (int)$request->input('availability');
        }

        return $data;
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function _validateFieldRules(Request $request): array
    {
        $validationRules = $this->movie::VALIDATION_RULES;

        if ('PATCH' === $request->method()) {
            if (!$request->has('title')) {
                unset($validationRules['title']);
            }

            if (!$request->has('description')) {
                unset($validationRules['description']);
            }

            if (!$request->has('stock')) {
                unset($validationRules['stock']);
            }

            if (!$request->has('sale_price')) {
                unset($validationRules['sale_price']);
            }

            if (!$request->has('rental_price')) {
                unset($validationRules['rental_price']);
            }
        } elseif ("PUT" === $request->method()) {
            $extraValidationRules = $this->movie::EXTRA_VALIDATION_RULES;
            return array_merge($validationRules, $extraValidationRules);
        }

        return $validationRules;
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
