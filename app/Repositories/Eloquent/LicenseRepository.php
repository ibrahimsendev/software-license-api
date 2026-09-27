<?php

namespace App\Repositories\Eloquent;

use App\Models\License;
use App\Repositories\Contracts\LicenseRepositoryInterface;

class LicenseRepository implements LicenseRepositoryInterface
{
    public function findAvailableLicenseForUpdate(int $productId): ?License
    {
        return License::where('product_id', $productId)
            ->whereNull('user_id')
            ->lockForUpdate()
            ->first();
    }

    public function assignToUser(License $license, int $userId): License
    {
        $license->update(['user_id' => $userId]);

        return $license;
    }
}
