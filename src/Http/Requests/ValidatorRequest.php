<?php

namespace Packagit\Common\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ValidatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function validate(array $rules, ...$params)
    {
        $validator = Validator::make($this->all(), $rules, ...$params);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->errors()->first(), null, Response::HTTP_BAD_REQUEST);
        }

        return $validator->validated();
    }
}
