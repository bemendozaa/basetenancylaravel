<?php

namespace App\Http\Resources\Central;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class TenantCollection extends ResourceCollection
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
                'subdomain' => optional($row->domain)->domain,
                'tenancy_db_name' => $row->tenancy_db_name,
            ];
        });

    }
}
