<?php

use App\Http\Controllers\AbsentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MerchandiserController;
use App\Http\Controllers\DailyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SummaryController;

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
// Routing Different Pages

Route::get('/', function () {
    return view('welcome');
});
// Login
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);
    // other admin routes...
});

// Merchandiser
Route::get('/merchandiser', [RouteController::class, 'merchandiser'])->name('merchandiserCRUD');
Route::post('/merchandiser', [MerchandiserController::class, 'store'])->name('merchandiser.store');
Route::get('/get-merchandiser-name', [MerchandiserController::class, 'getMerchandiserName']);
// Attendance
// Route::get('/attendance', [RouteController::class, 'attendance'])->name('attendance');

Route::get('/attendance/Daily', function () {
    return view('attendance');
})->name('attendance');

Route::get('/attendance/Daily/{selectedDate}', [DailyController::class, 'display'])->name('Daily.display');
Route::match(['get', 'post'], '/attendance/Daily/pagination/{selectedDate}', [DailyController::class, 'get_ajax_data']);



// Daily Post in Dailies table
Route::post('/attendance/Daily/submit-form', [DailyController::class, 'store'])->name('Daily.store');
// PDF
Route::get('/attendance/Daily/report/{selectedDate}', [DailyController::class, 'pdfdownload'])->name('Daily.report');


// Absences
Route::get('/absent', [AbsentController::class, 'index'])->name('Route.absent');
Route::post('/absent/update', [AbsentController::class, 'update'])->name('Absent.update');

// Summary
Route::get('/summary/pdf', [SummaryController::class, 'summaryPDF'])->name('Route.pdf');
Route::get('summary', [SummaryController::class, 'index'])->name('Route.summary');
Route::post('getSummary', [SummaryController::class, 'filter']);
// // Filter

// Employee
Route::get('/employee/{id}', [EmployeeController::class, 'show'])->name('employee.show');
Route::get('/employee/show/{id}', [EmployeeController::class, 'show2'])->name('employee.click');
Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.display');
Route::get('/employee/pdf/{id}', [EmployeeController::class, 'pdfEmployee'])->name('employee.pdf');
