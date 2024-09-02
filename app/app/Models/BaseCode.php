<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class BaseCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_1C',
        'name',
        'parent_id',
        'is_folder',
        'is_deleted',
        'created',
        'edited',
    ];

    protected $casts = [
        'created' => 'datetime',
        'edited' => 'datetime',
    ];

    abstract public function children();

}
