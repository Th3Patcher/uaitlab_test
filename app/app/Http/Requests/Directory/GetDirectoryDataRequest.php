<?php

namespace App\Http\Requests\Directory;

use App\Enums\Directory\DirectoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class GetDirectoryDataRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', new Enum(DirectoryType::class)],
            'search' => ['nullable', 'string', 'max:255'],
        ];
    }
}
