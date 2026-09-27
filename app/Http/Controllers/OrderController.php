<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\LicenseResource;
use App\Services\Contracts\OrderServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(
        protected OrderServiceInterface $orderService
    ) {}

    public function store(StoreOrderRequest $request): JsonResponse
    {
        try {
            $license = $this->orderService->createOrder(
                $request->validated('user_id'),
                $request->validated('product_id')
            );

            return response()->json([
                'message' => 'The order processed successfully and the license assigned.',
                'data' => new LicenseResource($license),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode() === 422 ? 422 : 500);
        }
    }
}
