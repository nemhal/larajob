## Prologue ##
This projects dispatches creates 20 new users and dispatches 20 new jobs for every new user. The idea is to be able to run only X number of jobs in Y amount of seconds. For this reason we are trying to use Redis Rate Limiting (throttling) with command `Redis::throttle`, as described in the documentation (https://laravel.com/docs/5.6/queues#rate-limiting) but something is not working right. After a successfuly executed X jobs in Y amount of time, all jobs after would hit the ->release(10);. That will actually get all the jobs after sucessfully executed ones delayed and after couple more delays a lot of jobs would time out: `App\Jobs\SampleJob has been attempted too many times or run too long. The job may have previously timed out.` The problem might be with the "key" for the throttle command. Also documentation suggests implementing "Time Based Attempts" (https://laravel.com/docs/5.6/queues#time-based-attempts) and I have tried that too but I would also get the same result.


## Objective ##
1. Allowing X amount of jobs to be executed in Y amount of seconds using Redis::throttle while other jobs won't fail after couple of minutes.
2. Alternatively, after X jobs run, pausing all jobs in a given queue for X amount of seconds (don't know if even possible)


## Testing Instructions ##

1. Set `QUEUE_DRIVER=redis` in .env

2. Set MySQL database connection at .env

3. Run `php artisan queue:failed-table`

4. Run `php artisan migrate`

5. Add jobs to Queue by visiting `/newJobs/20` in browser. (You can replace 20 by any number of jobs you want to add to the queue.)

6. Run php `artisan horizon` to start the woker and monitor laravel.log and `/horizon`

7. After about 5 minutes errors like this will start appearing in the error.log:
`[2018-08-31 22:21:14] local.ERROR: App\Jobs\SampleJob has been attempted too many times or run too long. The job may have previously timed out. {"exception":"[object] (Illuminate\\Queue\\MaxAttemptsExceededException(code: 0): App\\Jobs\\SampleJob has been attempted too many times or run too long. The job may have previously timed out. at /Users/halas/Code/larajob/vendor/laravel/framework/src/Illuminate/Queue/Worker.php:400)`

# Screenshots: #
- http://prntscr.com/kpej2y
- http://prntscr.com/kpejdn
