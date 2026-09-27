<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LicenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'license_key' => $this->license_key,
            'product' => new ProductResource($this->whenLoaded('product')),
            'assigned_user_id' => $this->user_id,
            'purchased_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
