<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyVersionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'version_number' => $this->version,
            'snapshot' => $this->data,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
