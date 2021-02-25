<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasMany as HasManyAlias;
class Client extends Model
{
    /**
     * @return HasManyAlias
     */
    public function products()
    {
        return $this->hasMany(ProductClient::class);
    }

}
