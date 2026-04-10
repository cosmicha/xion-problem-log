<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProblemLogController;
use App\Http\Controllers\Admin\UserApprovalController;

Route::get('/', function () {
    return redirect('/problem-logs');
});

require __DIR__.'/auth.php';

Route::get('/waiting-approval', function () {
    return view('waiting');
})->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [UserApprovalController::class, 'index']);
    Route::post('/admin/companies', [UserApprovalController::class, 'storeCompany']);
    Route::post('/admin/users/{user}/approve', [UserApprovalController::class, 'approve']);
    Route::put('/admin/users/{user}', [UserApprovalController::class, 'update']);
    Route::delete('/admin/users/{user}', [UserApprovalController::class, 'destroy']);
});

Route::middleware(['auth', 'approved'])->group(function () {

    Route::get('/engineer/dashboard', [ProblemLogController::class, 'engineerDashboard']);

    Route::get('/problem-logs/export', [ProblemLogController::class, 'export']);
    Route::post('/problem-logs/{problemLog}/acknowledge', [ProblemLogController::class, 'acknowledge']);
    Route::post('/problem-logs/{problemLog}/assign-engineer', [ProblemLogController::class, 'assignEngineer']);
    Route::post('/problem-logs/{problemLog}/close', [ProblemLogController::class, 'close']);

    Route::resource('problem-logs', ProblemLogController::class);
});

Route::post('/problem-logs/{problemLog}/take', [App\Http\Controllers\ProblemLogController::class, 'take']);
