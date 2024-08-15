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

        $responseXml = $this->client->GetOrdersSpecified($this->authData, '', 0, 10);
        return $this->formatResponse($responseXml);
    }

    public function formatResponse(string $xmlString): array
    {
        return XmlToArray::convert($xmlString);
    }
}
