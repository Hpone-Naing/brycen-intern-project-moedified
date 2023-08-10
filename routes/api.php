<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProjectAssignmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("employees/get-employees-ids/{id}", [EmployeeController::class, "getEmployeeById"]);
Route::get("employees/make-employees-id/", [EmployeeController::class, "getMakedEmployeeId"]);
Route::get("employees/get-employees-optional-columns-lazy-load/{id}", [EmployeeController::class, "getEmployeeByIdLazyLoad"]);
Route::get("employees/get-employees-projects-by-ids/{id}", [EmployeeController::class, "getEmployeeProjectById"]);
Route::get("projects/all", [ProjectAssignmentController::class, "getAllProjects"]);

# add new feature
Route::get("employees/get-active-employees", [EmployeeController::class, "getActiveEmployees"]);
Route::get("employees/get-passwords-request-pending-employees/{currentLoginEmployeeId}", [EmployeeController::class, "getInProgressToResetPasswordList"]);
Route::post("send-birthday-person-mail", [MailController::class, "sendBirthdayWishMail"]);


