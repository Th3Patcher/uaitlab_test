<?php

namespace App\Http\Requests\Directory;

use App\Enums\Directory\DirectoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;

class StoreDirectoryCodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Generate the table name based on selected type
        $table = str_replace(' ', '_', strtolower($this->input('type'))) . '_codes';

        return [
            'type' => ['required', new Enum(DirectoryType::class)],
            'folder' => ['nullable', 'string',
                function ($attribute, $value, $fail) use ($table) {
                    // Check if table exists
                    if (!DB::getSchemaBuilder()->hasTable($table)) {
                        $fail("The table {$table} does not exist.");
                        return;
                    }

                    // Check if folder exists in the table
                    if (!DB::table($table)->where('code_1C', $value)->exists()) {
                        $fail("The selected folder does not exist in the {$table} table.");
                    }
                },
            ],
            'name' => ['required', 'unique:' . $table, 'string', 'max:50'],
            'is_folder' => ['required', 'boolean'],
        ];
    }
}
