<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PopupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        // Customize the response structure
        return [
            'id' => $this->id,
            'type' => $this->popupType->name,
            'layout' => $this->popupLayoutType->name,
            'content' => $this->content,
            'owner' => $this->owner->name,
            'primary_variant' => new PopupVariantResource($this->whenLoaded('variants')),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString()
        ];
    }
}
