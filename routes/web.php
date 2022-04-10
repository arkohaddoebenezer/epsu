<?php

use App\Http\Controllers\RoutesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware(["isDistrict"])->group(function () {
    Route::get('users', [RoutesController::class, 'users'])->name('users');
    Route::get('council', [RoutesController::class, 'council'])->name('council');
    Route::get('executives', [RoutesController::class, 'executives'])->name('executives');
    Route::get('congress', [RoutesController::class, 'congress'])->name('congress');
    Route::get('institutions', [RoutesController::class, 'institutions'])->name('institutions');
    Route::get('groups', [RoutesController::class, 'groups'])->name('groups');
    Route::get('professional_members', [RoutesController::class, 'professional_members'])->name('professional_members');
    Route::get('presbyteries', [RoutesController::class, 'presbyteries'])->name('presbyteries');
});
Route::get('/', [RoutesController::class, 'dashboard'])->name("dashboard");
Route::get('/dashboard', [RoutesController::class, 'dashboard'])->name("dashboard");
Route::get('districts', [RoutesController::class, 'districts'])->name('districts')->middleware('isDistrict');
Route::get('branches', [RoutesController::class, 'branches'])->name('branches')->middleware('isBranch');
Route::get('unions', [RoutesController::class, 'unions'])->name('unions')->middleware('isUnion');

Route::get('congress_members', [RoutesController::class, 'congress_members'])->name('congress_members');

Route::get('members', [RoutesController::class, 'members'])->name('members');
Route::get('messaging', [RoutesController::class, 'messaging'])->name('messaging');
Route::get('/logout', function () {
    Auth::logout();
    return redirect("/");
});

require __DIR__ . '/auth.php';
