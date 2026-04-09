<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProblemLogController;

Route::get('/', function () {
    return redirect('/problem-logs');
});

Route::resource('problem-logs', ProblemLogController::class);
Route::post('/problem-logs/{problemLog}/acknowledge', [ProblemLogController::class, 'acknowledge']);
Route::post('/problem-logs/{problemLog}/close', [ProblemLogController::class, 'close']);
