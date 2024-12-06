<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
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
            'name' => 'required|string|unique:branches,name,' . $this->route('branch'),
            'address' => 'required|string',
            'country' => 'required|exists:countries,id',
            'state' => 'required|exists:states,id',
            'city' => 'required|exists:cities,id',
            'pincode' => 'required|numeric|digits:6',
        ];
    }
}
