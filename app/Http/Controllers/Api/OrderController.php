<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Services\AtomStoreService;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
        return OrderResource::collection(['awdawd']);
    }
}
