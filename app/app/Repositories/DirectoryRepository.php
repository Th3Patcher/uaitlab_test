<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DirectoryRepository
{
    //Initialized the class by the 'type' value in requests
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

    public function create($data)
    {
        return (new $this->dirClass())->create([
            'code_1C' => Str::uuid(),
            'name' => $data['name'],
            'parent_id' => $data['is_folder'] ? 0 : $data['folder'],
            'is_folder' => $data['is_folder'],
            'is_deleted' => 0,
            'created' => Carbon::now(),
            'edited' => Carbon::now(),
        ])->save();
    }

    public function findCode($id) {
        $code = $this->dirClass::find($id);

        if (is_null($code)) {
            throw new \Exception('Code not found in directory');
        }

        return $code;
    }

    public function updateCode($id, $newData)
    {
        $code = $this->findCode($id);

        if ($code) {
            $code->name = $newData['name'];

            return $code->save();
        }

        return false;
    }
}
