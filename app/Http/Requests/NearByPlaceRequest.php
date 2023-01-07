<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NearByPlaceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'establishments' => ['sometimes', 'string'],
            'lattitude' => ['required', 'decimal:1,7'],
            'longhitude' => ['required', 'decimal:1,7'],
        ];
    }
}
