<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;


class Item extends Model
{

    protected $fillable = [
        'name',
        'price',
    ];

}
