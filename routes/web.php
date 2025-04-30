<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TicketController;
use App\Models\User;


Route::get('/', function () {
    return Inertia::render('Home');
});


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard');
//     })->name('dashboard');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', function () {
        if (auth()->user()->hasRole('admin')) {
            abort(403, 'Admins are not allowed to create tickets.');
        }
        return Inertia::render('Tickets/Create');
    })->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::put('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    Route::post('/tickets/{ticket}/comment', [TicketController::class, 'addComment'])->name('tickets.addComment');
});
// Route::get('/make-admin', function () {
//     $user = User::find(5);
//     $user->assignRole('admin');
//     return 'User promoted to admin!';
// });
