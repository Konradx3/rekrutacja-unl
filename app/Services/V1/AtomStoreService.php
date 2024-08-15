<?php

namespace App\Services\V1;

use Mtownsend\XmlToArray\XmlToArray;
use SoapClient;

class AtomStoreService
{
    protected $client;
    protected $authData;

    public function __construct()
    {
        $this->authData = [
            'login' => env('ATOMSTORE_USER'),
            'password' => env('ATOMSTORE_PASSWORD'),
        ];

        $this->client = new SoapClient(env('ATOMSTORE_API'), $this->authData);

        if (strtoupper($this->client->CheckConnection($this->authData)) === 'WRONG AUTHORIZATION')
        {
            $this->client = null;
        }
    }

    public function getOrders(): array
    {
        if ($this->client == null)
        {
            return [
                'error' => 'Invalid Credentials',
                'status' => 401,
            ];
        }

        $responseXml = $this->client->GetOrdersSpecified($this->authData, '', 0, 0, 0, '', '');
        return $this->formatResponse($responseXml);
    }

    public function getOrderById(int $orderId): array
    {
        if ($this->client == null)
        {
            return [
                'error' => 'Invalid Credentials',
                'status' => 401,
            ];
        }

        $extraFilter = sprintf('id|%s', $orderId);
        $responseXml = $this->client->GetOrdersSpecified($this->authData, '', 0, 10, 0, '', '', $extraFilter);
        $responseArray = $this->formatResponse($responseXml);

        if (empty($responseArray))
        {
            return [
                'error' => 'Resource not found',
                'status' => 404,
            ];
        }

        return $responseArray;
    }


    public function formatResponse(string $xmlString): array
    {
        return XmlToArray::convert($xmlString);
    }
}
