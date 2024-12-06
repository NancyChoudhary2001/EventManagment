<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'phonenumber' => 'required|unique:users,phone_number|digits:10',
        ];
    }
    final protected function failedValidation(Validator $validator)
        {
            
            $errors = $validator->errors()->messages();
            $formattedErrors = [];
            foreach ($errors as $key => $message) {
                foreach (array_keys($this->file()) as $fieldKey) {
                    if (strpos($key, $fieldKey) !== false) {
                        $key = $fieldKey;
                    }
                }
                $formattedErrors[$key] = $message[0];
            }

            throw new HttpResponseException(response()->json(['success'=> false, 'message' => $formattedErrors], status:412));
        }
}
