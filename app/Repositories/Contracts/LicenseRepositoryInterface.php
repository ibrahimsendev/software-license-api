<?php

namespace App\Repositories\Contracts;

use App\Models\License;

interface LicenseRepositoryInterface
{
    public function findAvailableLicenseForUpdate(int $productId): ?License;

    public function assignToUser(License $license, int $userId): License;
}
