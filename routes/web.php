<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Agenda;
use App\Http\Controllers\FrontAgendaController;

// ===============================
// ROUTE UNTUK USER
// ===============================

// Halaman utama user
Route::get('/', function () {
    $agendas = Agenda::where('is_archived', false)
        ->orderBy('date', 'asc')
        ->orderBy('start_time', 'asc')
        ->get();

    return view('agenda.index', compact('agendas'));
})->name('home');

// ===============================
// LOGIN / LOGOUT ADMIN
// ===============================

Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', function (Request $request) {
    if ($request->email === 'admin@ombudsman.com' && $request->password === 'orisumsel07') {
        Session::put('is_admin', true);
        return redirect()->route('admin.dashboard');
    }
    return back()->with('error', 'Email atau password salah.');
});

Route::post('/logout', function () {
    Session::flush();
    return redirect()->route('login');
})->name('logout');

// ===============================
// ROUTE UNTUK ADMIN
// ===============================

Route::prefix('admin')->middleware(AdminMiddleware::class)->name('admin.')->group(function () {

    // Dashboard admin
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // CRUD utama agenda
    Route::resource('agenda', AgendaController::class)->except(['show']);

    // Arsip agenda
    Route::patch('agenda/{id}/archive', [AgendaController::class, 'archive'])->name('agenda.archive');
    Route::get('agenda/archived', [AgendaController::class, 'archived'])->name('agenda.archived');

    // Export Excel agenda
    Route::get('agenda/export', [AgendaController::class, 'export'])->name('agenda.export');

});

