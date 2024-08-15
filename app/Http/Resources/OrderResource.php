<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'order',
            'id' => $this['id'],
            'external_id' => $this['externalId'],
            'confirmed' => $this['confirmed'],
            'shipping_method' => $this['paymentMethodId'],
            'total_products' => '$this->total_products',
            'products' => [
                'product_list' => 'products',
            ],

            $this->mergeWhen($request->user()->isAdmin(), [
                'currency' => $this['currency'],
                'order_sum' => $this['order_sum'],
                'paid' => $this['paid'],
                'username' => $this['client']['username'],
            ]),

            $this->mergeWhen($request->routeIs('orders.show'), [
                'shipping_details' => [
                    'shipping_first_name' => '$this->currency',
                    'shipping_last_name' => '$this->shipping_last_name',
                    'shipping_company' => '$this->shipping_company',
                    'shipping_street' => '$this->shipping_street',
                    'shipping_street_number_1' => '$this->shipping_street_number_1',
                    'shipping_street_number_2' => '$this->shipping_street_number_2',
                    'shipping_post_code' => '$this->shipping_post_code',
                    'shipping_city' => '$this->shipping_city',
                    'shipping_state_code' => '$this->shipping_state_code',
                    'shipping_state' => '$this->shipping_state',
                    'shipping_country_code' => '$this->shipping_country_code',
                    'shipping_country' => '$this->shipping_country',
                ],
            ]),
        ];
    }
}
