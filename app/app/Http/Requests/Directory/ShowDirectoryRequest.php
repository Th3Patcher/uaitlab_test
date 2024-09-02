<?php

namespace App\Http\Requests\Directory;

use App\Enums\Directory\DirectoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;

class ShowDirectoryRequest extends FormRequest
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
            'id' => ['required', 'int'],
        ];
    }
}
