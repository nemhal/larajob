<?php

use App\User;
use App\Jobs\SampleJob;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('newJobs/{num}', function($num) {
    // Adds a new $num number jobs to the queue
    for ($i = 1; $i < $num; $i++) {
        // Create a new user
        $user = factory(App\User::class)->create();
        // Queue a SampleJob
        SampleJob::dispatch($user);
    }
    Log::info('New '.$num.' jobs dispatched to Queue');
    echo "Queued ".$num." new SampleJobs. Click here to <a href='/'><strong>go back</strong></a>";
})->where('num', '[0-9]+');