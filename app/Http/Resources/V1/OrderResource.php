<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (isset($this['products']) && is_array($this['products']))
        {
            $totalProducts = count($this['products']);
            $products = array_map(function ($product) {
                return new ProductResource($product);
            }, $this['products']);
        }

        return [
            'type' => 'order',
            'id' => $this['id'],
            'external_id' => $this['externalId'] ?? '',
            'confirmed' => $this['confirmed'],
            'shipping_method' => $this['shippingMethod'],

            'total_products' => $totalProducts ?? 0,
            'products' => $products ?? [],


            $this->mergeWhen($request->user()->isAdmin(), [
                'currency' => $this['currency'],
                'order_sum' => $this['order_sum'],
                'paid' => $this['paid'],
                'username' => $this['client']['username'],
            ]),

            $this->mergeWhen($request->routeIs('orders.show'), [
                'shipping_details' => $this->getShippingDetails($this['client']),
            ]),
        ];
    }

    private function getShippingDetails(array $client): array
    {
        return [
            'shipping_first_name' => $client['shippingFirstName'],
            'shipping_last_name' => $client['shippingLastName'],
            'shipping_company' => $client['shippingCompany'],
            'shipping_street' => $client['shippingStreet'],
            'shipping_street_number_1' => $client['shippingStreetNumber1'],
            'shipping_street_number_2' => $client['shippingStreetNumber2'],
            'shipping_post_code' => $client['shippingPostCode'],
            'shipping_city' => $client['shippingCity'],
            'shipping_state_code' => $client['shippingState'],
            'shipping_state' => $client['shippingState'],
            'shipping_country_code' => $client['shippingCountryCode'],
            'shipping_country' => $client['shippingCountry'],
        ];
    }
}
