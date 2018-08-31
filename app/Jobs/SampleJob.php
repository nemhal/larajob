<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Log;
use Illuminate\Support\Facades\Redis;

class SampleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Throtle jobs (1 job every 60 seconds)
        Redis::throttle('key')->allow(1)->every(60)->then(function () {
            // Do the API call in here
            Log::info('This job is finished! No other jobs should be execured for next 60 seconds!');
        }, function () {
            Log::info('Job delayed 10 seconds!');
            return $this->release(10);
        });
    }
}
