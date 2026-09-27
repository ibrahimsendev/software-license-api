<?php

namespace App\Services\Contracts;

use App\Models\License;

interface OrderServiceInterface
{
    public function createOrder(int $userId, int $productId): License;
}
