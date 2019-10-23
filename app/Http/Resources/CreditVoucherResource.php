<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CreditVoucherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $paid = (float) $this->paid();

        return [
            'id' => $this->id,
            'sectors' => $this->sectors->pluck('sector.name')->implode(', '),
            'date' => $this->date->format('d F, Y'),
            'total_amount' => $this->total_amount,
            'paid' => $paid,
            'due' => ($this->total_amount - $paid)
        ];
    }
}
