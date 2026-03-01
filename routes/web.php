<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Mail\InvitationMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\InvitationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');
Route::get('/colocations', [ColocationController::class, 'index'])->name('colocations.index');
Route::get('/colocations/{id}', [ColocationController::class, 'show'])->name('colocations.show');
Route::delete('/colocations/{id}', [ColocationController::class, 'destroy'])->name('colocations.destroy');
Route::post('/colocations/{colocation}/leave', [ColocationController::class, 'leave'])->name('colocations.leave');

Route::post('/invitation', [InvitationController::class, 'sendInvitation'])
    ->middleware(['auth'])->name('invitation.invite');

Route::get('/invitation/response/{token}', [InvitationController::class, 'showResponsePage'])
    ->name('invitation.response');

Route::post('/invitation/accept/{token}', [InvitationController::class, 'accept'])
    ->middleware(['auth'])
    ->name('invitation.accept');

Route::post('/invitation/refuse/{token}', [InvitationController::class, 'refuse'])
    ->middleware(['auth'])
    ->name('invitation.refuse');        

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
