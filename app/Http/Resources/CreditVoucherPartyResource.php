<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CreditVoucherPartyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'party' => [
                'name' => $this->name,
                'phone' => $this->phone,
            ],
            'vouchers' => CreditVoucherResource::collection($this->creditVouchers)
        ];
    }
}
