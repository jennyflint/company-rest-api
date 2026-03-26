<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanySyncResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status->value,
            'company' => new CompanyResource($this->company),
        ];
    }
}
