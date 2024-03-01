<?php

namespace App\Models\Tenant;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends BaseModel
{

    use HasFactory;
    
    protected $fillable = [
        'name',
        'number',
    ];

    
    /**
     * 
     * Retorna columnas de busqueda para datatable
     *
     * @return array
     */
    public function getSearchColumns(): array
    {
        return [
            [
                'value' => 'name', 
                'name' => 'Nombre'
            ],
            [
                'value' => 'number', 
                'name' => 'Número'
            ],
        ];
    }
    
}
