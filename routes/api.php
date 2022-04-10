<?php

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CongressController;
use App\Http\Controllers\CongressMembersController;
use App\Http\Controllers\CouncilController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ExecutivesController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\PresbyteryController;
use App\Http\Controllers\ProfessionalGroupController;
use App\Http\Controllers\ProfessionalMembersController;
use App\Http\Controllers\UnionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Check if user is authenticated
Route::middleware(["auth:sanctum"])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

 //Route for presbyteries module
 Route::prefix('presbyteries')->group(function () {
    Route::post('update', [PresbyteryController::class, 'update']);
});
Route::resource('presbyteries', PresbyteryController::class);

//Route for districts module
Route::prefix('districts')->group(function () {
    Route::get('{presbytery}', [DistrictController::class, 'districts']);
    Route::post('update', [DistrictController::class, 'update']);
});
Route::resource('districts', DistrictController::class);

//Route for branches module
Route::prefix('branches')->group(function () {
    Route::get('{presbytery}/{district}', [BranchController::class, 'branches']);
    Route::post('update', [BranchController::class, 'update']);
});
Route::resource('branches', BranchController::class);

//Route for unions module
Route::prefix('unions')->group(function () {
    Route::get('{presbytery}/{district}/{branch}', [UnionController::class, 'unions']);
    Route::post('update', [UnionController::class, 'update']);
});
Route::resource('unions', UnionController::class);

//Route for members module
Route::prefix('members')->group(function () {
    Route::get('{presbytery}/{district}/{branch}/{union}', [MemberController::class, 'members']);
    Route::post('update', [MemberController::class, 'update']);
});
Route::resource('members', MemberController::class);

//Route for institutions module
Route::prefix('institutions')->group(function () {
    Route::post('update', [InstitutionController::class, 'update']);
});
Route::resource('institutions', InstitutionController::class);

//Route for professional_groups module
Route::prefix('groups')->group(function () {
    Route::post('update', [ProfessionalGroupController::class, 'update']);
});
Route::resource('groups', ProfessionalGroupController::class);

//Route for professional_members module
Route::prefix('professional_members')->group(function () {
    Route::post('update', [ProfessionalMembersController::class, 'update']);
});
Route::resource('professional_members', ProfessionalMembersController::class);

//Route for councils module
Route::prefix('councils')->group(function () {
    Route::post('update', [CouncilController::class, 'update']);
});
Route::resource('councils', CouncilController::class);

//Route for executives module
Route::prefix('executives')->group(function () {
    Route::post('update', [ExecutivesController::class, 'update']);
});
Route::resource('executives', ExecutivesController::class);

 //Route for congress module
 Route::prefix('congress')->group(function () {
    Route::post('update', [CongressController::class, 'update']);
});
Route::resource('congress', CongressController::class);

 //Route for congress_members module
 Route::prefix('congress_members')->group(function () {
    Route::get('{union}/{congress}', [CongressMembersController::class, 'members']);
    Route::post('update', [CongressMembersController::class, 'update']);
});
Route::resource('congress_members', CongressMembersController::class);

 //Route for messages module
 Route::prefix('messages')->group(function () {
    Route::post('update', [MessagesController::class, 'update']);
});
Route::resource('messages', MessagesController::class);

 //Route for users module
 Route::prefix('users')->group(function () {
    Route::post('update', [UserController::class, 'update']);
});
Route::resource('users', UserController::class);



Route::post('send_single_sms',[MessageController::class,'sendSingleSms']);
Route::post('send_bulk_sms',[MessageController::class,'sendbulksms']);
Route::post('due_subscription_notice',[MessageController::class,'sendDueNoticeSms']);
Route::post('send_bulk_email',[MessageController::class,'sendBulkEmail']);
Route::post('send_single_email',[MessageController::class,'sendSingleEmail']);
Route::get('previous_single_sms',[MessageController::class,'sentsingleSms']);
Route::get('previous_bulk_sms',[MessageController::class,'sentbulkSms']);
Route::get('previous_bulk_email',[MessageController::class,'sentBulkEmail']);
Route::get('previous_single_email',[MessageController::class,'sentSingleEmail']);
Route::post("change-password", [NewPasswordController::class, "reset"]);
