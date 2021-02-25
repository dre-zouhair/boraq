<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo as belongsToAlias;
use Illuminate\Database\Eloquent\Relations\HasMany as HasManyAlias;

class Product extends Model
{
    protected  $guarded = [];
    /**
     * @return HasManyAlias
     */
    public function productserials()
    {
        return $this->hasMany(ProductSerial::class);
    }
    /**
     * @return belongsToAlias
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
