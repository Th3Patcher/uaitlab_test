<?php

namespace App\Models;

class DefectCode extends BaseCode
{
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'code_1C');
    }
}
