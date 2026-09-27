<?php

namespace App\Services\Services;

use App\Jobs\SendLicenseEmailJob;
use App\Models\License;
use App\Repositories\Contracts\LicenseRepositoryInterface;
use App\Services\Contracts\OrderServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService implements OrderServiceInterface
{
    public function __construct(
        protected LicenseRepositoryInterface $licenseRepository
    ) {}

    public function createOrder(int $userId, int $productId): License
    {
        return DB::transaction(function () use ($userId, $productId) {
            $license = $this->licenseRepository->findAvailableLicenseForUpdate($productId);

            if (! $license) {
                throw new Exception('The licenses available in stock have run out.', 422);
            }

            $updatedLicense = $this->licenseRepository->assignToUser($license, $userId);

            SendLicenseEmailJob::dispatch($updatedLicense, $userId);

            return $updatedLicense;
        });
    }
}
