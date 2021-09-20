<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class SmsCheckRequest extends FormRequest
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
            'phone' => 'required|min:10|max:18',
            'message' => 'required|min:4|max:255'
        ];
    }

    public function expectsJson()
    {
        return true;
    }

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            $errors = (new ValidationException($validator))->errors();
            $messages = (new ValidationException($validator))->getMessage();
            throw new HttpResponseException(
                response()->json(['success' => 0, 'messages' => $messages, 'errors' => $errors], 422)
            );
        }

        parent::failedValidation($validator);
    }
}
