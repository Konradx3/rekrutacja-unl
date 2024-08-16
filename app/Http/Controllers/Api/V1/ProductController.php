<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductResource;
use App\Services\V1\AtomStoreService;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    use ApiResponses;

    protected $atomStore;

    public function __construct(AtomStoreService $atomStoreService)
    {
        $this->atomStore = $atomStoreService;
    }

    /**
     * Get Specify Product
     *
     * Get specify product by his id from AtomStore.
     *
     * @urlParam id int required
     * @unauthenticated
     * @group Managing Products
     * @response 200 {
     * "data": {}
     *
     */
    public function show(int $productId)
    {
        $data = $this->atomStore->getProductById($productId);

        if (isset($data['error']))
        {
            return $this->error($data['error'], $data['status']);
        }

        return ProductResource::collection($data);
    }
}
