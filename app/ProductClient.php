<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo as belongsToAlias;

class ProductClient extends Model
{
    /**
     * @return belongsToAlias
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    /**
     * @return belongsToAlias
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
