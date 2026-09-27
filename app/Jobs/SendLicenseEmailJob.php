<?php

namespace App\Jobs;

use App\Models\License;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendLicenseEmailJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public License $license,
        public int $userId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("User #{$this->userId} for product #{$this->license->produduct_id}. Key: {$this->license->license_key}");
    }
}
