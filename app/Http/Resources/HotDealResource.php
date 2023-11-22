<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotDealResource extends JsonResource
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
            'company' => [
                'id' => $this->company->id,
                'name' => $this->company->name,
            ],
            'container_size' => [
                'id' => $this->containerSize->id,
                'display_label' => $this->containerSize->display_label,
                'value' => $this->containerSize->value,
            ],
            'price_amount' => $this->amount,
            'origin' => [
                'id' => $this->origin->id,
                'code' => $this->origin->code,
                'city' => $this->origin->city,
                'port' => $this->origin->port,
                'country' => [
                    'id' => $this->origin->country->id,
                    'name' => $this->origin->country->name,
                    'code' => $this->origin->country->code,
                ]
            ],
            'destination' => [
                'id' => $this->destination->id,
                'code' => $this->destination->code,
                'city' => $this->destination->city,
                'port' => $this->destination->port,
                'country' => [
                    'id' => $this->destination->country->id,
                    'name' => $this->destination->country->name,
                    'code' => $this->destination->country->code,
                ]
            ],
            'etd' => $this->etd,
            'eta' => $this->eta,
            'tt' => $this->tt,
            'valid_till' => $this->valid_till
        ];
    }
}
