<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;


/**
 * @property mixed $login
 * @property mixed $password
 */
class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'login'    => 'required',
            'password' => 'required'
        ];
    }

    /**
     * @return bool
     */
    public function expectsJson(): bool
    {
        return true;
    }

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
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            $errors = (new ValidationException($validator))->errors();
            $messages = (new ValidationException($validator))->getMessage();
            throw new HttpResponseException(
                response()->json(['success' => false, 'messages' => $messages, 'errors' => $errors], 422)
            );
        }

        parent::failedValidation($validator);
    }
}
