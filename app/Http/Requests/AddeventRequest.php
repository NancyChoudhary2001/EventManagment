<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;

class AddeventRequest extends FormRequest
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
            'name' => 'required|string|unique:events,name',
            'description' => 'required|string',
            'role' => 'required|in:admin,user', 
            'currency' => 'required|exists:currencies,id',
            'price' => 'required|numeric|min:0',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        
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
