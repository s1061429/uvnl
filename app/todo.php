<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class todo extends Model
{
    public function setBodyAttribute($value) {
        return $this->attributes['body'] = strtoupper($value);
    }
}
