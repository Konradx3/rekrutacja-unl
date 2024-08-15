<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\OrderCollection;
use App\Http\Resources\V1\OrderResource;
use App\Services\V1\AtomStoreService;
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

    /**
     * Get Orders List
     *
     * Get all available orders from AtomStore.
     *
     * @unauthenticated
     * @group Managing Orders
     * @response 200 {
     * "data": {
     * "order": {
     * "orders": [
     * {
     * "type": "order",
     * "id": "77",
     * ...
     * }}}}
     *
     */
    public function index(): ResourceCollection|JsonResponse
    {
        $data = $this->atomStore->getOrders();

        if (isset($data['error']))
        {
            return $this->error($data['error'], $data['status']);
        }

        return OrderCollection::collection($data);
    }

    /**
     * Get Specify Order
     *
     * Get specify order from order list in AtomStore.
     *
     * @urlParam id int required
     * @unauthenticated
     * @group Managing Orders
     * @response 200 {
     * "data": {
     * "order": {
     * "type": "order",
     * "id": "94",
     * ...
     * }}}
     *
     */
    public function show(int $id): ResourceCollection|JsonResponse
    {
        $data = $this->atomStore->getOrderById($id);

        if (isset($data['error']))
        {
            return $this->error($data['error'], $data['status']);
        }

        return OrderResource::collection($data);
    }
}
