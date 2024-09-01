<?php

namespace App\Repositories;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DirectoryRepository
{
    protected $dirClass;

    public function __construct(string $dir)
    {
        $this->dirClass = "App\\Models\\{$dir}Code";
    }

    public function getDirectory($search = '')
    {
        return
            $this->dirClass::with('children')->when($search, function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
            })->get();
    }

    public function getFolders()
    {
        return $this->dirClass::query()->where('is_folder', 1)->get();
    }

    public function create($name, $parent_id = null)
    {
        return (new $this->dirClass())->create([
            'code_1C' => Str::uuid(),
            'name' => $name,
            'parent_id' => $parent_id,
            'is_folder' => 0,
            'is_deleted' => 1,
            'created' => Carbon::now(),
            'edited' => Carbon::now(),
        ])->save();
    }
}
