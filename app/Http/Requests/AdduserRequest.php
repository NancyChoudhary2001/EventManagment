<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdduserRequest extends FormRequest
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

            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'role' => 'required|string|in:admin,user',
            'phone' => 'required|unique:users,phone_number|digits:10',
            'email' => 'required|email|unique:users,email',
            'address' => 'nullable|string',
            'country' => 'nullable',
            'state' => 'nullable',
            'city' => 'nullable',
            'pin' => 'nullable|numeric|digits:6',
            'branch' => 'nullable',
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

