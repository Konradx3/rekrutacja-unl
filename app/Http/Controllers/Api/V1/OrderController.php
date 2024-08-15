<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\OrderCollection;
use App\Http\Resources\V1\OrderResource;
use App\Services\V1\AtomStoreService;
use App\Traits\ApiResponses;

class OrderController extends Controller
{
    use ApiResponses;

    protected $atomStore;

    public function __construct(AtomStoreService $atomStoreService)
    {
        $this->atomStore = $atomStoreService;
    }

    /*
     * Orders list
     **/
    public function index()
    {
        $data = $this->atomStore->getOrders();

        if (isset($data['error']))
        {
            return $this->error($data['error'], $data['status']);
        }

        return OrderCollection::collection($data);
    }

    /*
     * Show specify order
     **/
    public function show(int $id)
    {
        $data = $this->atomStore->getOrderById($id);

        if (isset($data['error']))
        {
            return $this->error($data['error'], $data['status']);
        }

        return OrderResource::collection($data);
    }
}
