<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(auth()->user()){
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'merek' => ['required', 'string', 'max:100'],
            'no_plat' => ['required', 'string', 'max:15'],
            'harga_sewa' => ['required', 'numeric', 'min:1'],
            'ketersediaan' => ['required', 'numeric', 'min:1'],
        ];
    }
}
