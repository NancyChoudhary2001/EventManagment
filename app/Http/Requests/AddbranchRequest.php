<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class AddbranchRequest extends FormRequest
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
        'name' => 'required|string|unique:newbranches,name',
            'address' => 'required|string',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required|numeric|digits:6',
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
