<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use App\Models\Team;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ProjectMaterialLogController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\ItemReplacementController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::get('/dashboard/data', [DashboardController::class, 'getData'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.data');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('leads', LeadController::class);
Route::resource('teams', TeamController::class);
Route::resource('projects', ProjectController::class);
Route::resource('estimates', EstimateController::class);
Route::resource('complaints', ComplaintController::class);
// Optional route to remove single image (POST)
Route::post('complaints/{complaint}/images/{image}/remove', [ComplaintController::class, 'removeImage'])
    ->name('complaints.images.remove');
Route::get('estimates/{estimate}/pdf', [EstimateController::class, 'pdf'])->name('estimates.pdf');
Route::post('/leads/{lead}/update-status', [LeadController::class, 'updateStatus'])
    ->name('leads.updateStatus');
Route::post(
    '/complaints/{complaint}/update-status',
    [ComplaintController::class, 'updateStatus']
)->name('complaints.updateStatus');

Route::resource('projects', ProjectController::class);
Route::post(
    'projects/material/add',
    [ProjectMaterialLogController::class, 'store']
)->name('projects.material.store');
Route::get(
    '/projects/{id}/material-history-pdf',
    [ProjectController::class, 'materialHistoryPdf']
)->name('projects.material.pdf');

Route::resource('technicians', TechnicianController::class);
Route::delete(
    '/projects/material/{material}',
    [ProjectMaterialLogController::class, 'destroy']
)->name('projects.material.destroy');
// Route for Item Replacements
Route::resource('replacements', ItemReplacementController::class);

require __DIR__ . '/auth.php';
