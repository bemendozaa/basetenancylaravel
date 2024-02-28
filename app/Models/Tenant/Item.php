<?php

namespace App\Models\Tenant;

use App\Models\BaseModel;

class Item extends BaseModel
{

    protected $fillable = [
        'name',
        'price',
    ];

}
