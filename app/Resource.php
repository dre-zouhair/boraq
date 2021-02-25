<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\belongsTo as belongsToAlias;

class Resource extends Model
{
    /**
     * @return belongsToAlias
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
