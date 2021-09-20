<?php

namespace App\Http\Requests;

class BasicRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules()
    {
        return [];
    }

    /**
     * Validate request data
     * @param array $data
     * @return array
    */
    public static function validate($data = []) {
        return ['isValid' => true, 'message' => ''];
    }


}
