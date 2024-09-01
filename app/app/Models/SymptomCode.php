<?php

namespace App\Models;

class SymptomCode extends BaseCode
{
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'code_1C');
    }
}
