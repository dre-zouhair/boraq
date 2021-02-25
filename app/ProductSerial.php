<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo as belongsToAlias;

class ProductSerial extends Model
{
    protected $guarded = [];
    /**
     * @return belongsToAlias
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
