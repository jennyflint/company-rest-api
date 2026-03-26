<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'company_id' => $this->id,
            'name' => $this->name,
            'edrpou' => $this->edrpou,
            'address' => $this->address,
            'current_version' => $this->getCurrentVersionAttribute(),
            'history' => CompanyVersionResource::collection($this->whenLoaded('versions')),
        ];
    }
}
