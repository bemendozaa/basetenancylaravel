<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;


class ItemCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): Collection
    {
        return $this->collection->transform(function($row, $key) {
            return [
                'id' => $row->id,
                'name' => $row->name,
                'price' => $row->price,
            ];
        });

    }
}
