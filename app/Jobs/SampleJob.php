<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Log;
use App\User;
use Illuminate\Support\Facades\Redis;

class SampleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * The user instance.
     *
     * @var \App\User
     */
    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Throtle jobs (1 job every 60 seconds)
        Redis::throttle('App\User')->allow(1)->every(60)->then(function () {
            // Do some the API call in here
            
            // Log for the debugging that this job is finished
            Log::info('This job is finished [ '.$this->user->id.', '.$this->user->name.' ]. No other jobs should be execured for next 60 seconds!');
        }, function () {

            // This job got delayed because of the throttle
            Log::info('Job delayed 10 seconds! ['.$this->user->id.']');
            return $this->release(10);

        });
    }

}
