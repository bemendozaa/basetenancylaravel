<?php

namespace App\Models\Tenant;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends BaseModel
{

    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

}
