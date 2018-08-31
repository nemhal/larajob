<?php

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

Route::get('/newJobs', function(){
    $num = 20;
    // Adds a new 100 jobs to the queue
    for ($i = 1; $i < $num; $i++) {
        SampleJob::dispatch($i);
    }
    Log::info('New '.$num.' jobs dispatched to Queue');
    echo "Queued '.$num.' new SampleJobs. Click here to <a href='/'><strong>go back</strong></a>";
});