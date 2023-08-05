<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProjectAssignmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('authentication.login');
});

Route::post("login-users", function(){
    return redirect('index');
})->middleware('check-login-user');

Route::match(['get', 'post'] ,"show-all-pages", [EmployeeController::class, "showEmployeesForm"])->name("show-all");
Route::get("show-edit-pages", [EmployeeController::class, "showEditForm"])->middleware('check-session', 'check-role');
Route::get("show-save-pages", [EmployeeController::class, "showSaveForm"]);
Route::get("show-detail-pages", [EmployeeController::class, "showDetailForm"]);
Route::post("save-employees", [EmployeeController::class, "saveEmployee"]);
Route::delete("delete-employees", [EmployeeController::class, "deleteEmployee"]);
Route::get("/employees/download-excels/", [EmployeeController::class, "downloadExcel"]);
Route::get("/employees/download-pdfs/", [EmployeeController::class, "downloadPdf"]);
Route::post("update-employees/{id}", [EmployeeController::class, "updateEmployee"]);
Route::get("logout")->middleware('logout');

Route::post("save-projects-assignments", [ProjectAssignmentController::class, "saveProjectAssignment"]);
Route::get("show-create-project-assignments-pages", [ProjectAssignmentController::class, "getCreateForm"]);
Route::post("save-projects", [ProjectAssignmentController::class, "saveProject"]);
Route::delete("delete-projects", [ProjectAssignmentController::class, "deleteProject"]);
Route::get('download-documentations/{file}', [ProjectAssignmentController::class, "downloadDocumentations"])->name('download');
Route::get('language/{locale}', [LanguageController::class, "changeLanguage"])->name('set.language');

/**
 * Add new feature and ui template
 */
Route::match(['get', 'post'] ,"index", [EmployeeController::class, "showDashboard"])->name("show-dashboard");
Route::get("list", [EmployeeController::class, "showAllEmployees"])->name("show-all-employees");
Route::get("add-new", [EmployeeController::class, "getCreateForm"])->name("add-new-employees");
Route::get("edit-pages", [EmployeeController::class, "getEditForm"]);

Route::get("create-project-assignments", [ProjectAssignmentController::class, "getProjectAssignmentForm"]);
Route::get("request-forget-passwords-forms", [PasswordResetController::class, "getPasswordResetForm"]);
Route::post("request-reset-passwords", [PasswordResetController::class, "requestResetPassword"]);
Route::post("reset-passwords", [PasswordResetController::class, "resetPassword"]);
Route::post("members-passwords-reset", [PasswordResetController::class, "memberPasswordReset"]);
Route::get("pending-reset-password-list-form", [PasswordResetController::class, "getPendingPasswordResetEmployeesForm"]);

Route::get("sendbasicemail", [MailController::class, "basic_email"]);
Route::get("sendhtmlemail", [MailController::class, "html_email"]);
Route::get("sendattachmentemail", [MailController::class, "attachment_email"]);







