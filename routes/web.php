<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\AutherController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookIssueController;
use App\Http\Controllers\BrokenBookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StudentController;
use App\Models\BrokenBook;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');
Route::post('/', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Route::post('/Change-password', [LoginController::class, 'changePassword'])->name('change_password');


Route::middleware('auth')->group(function () {
    Route::get('change-password',[dashboardController::class,'change_password_view'])->name('change_password_view');
    Route::post('change-password',[dashboardController::class,'change_password'])->name('change_password');
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');

    // author CRUD
    Route::get('/authors', [AutherController::class, 'index'])->name('authors');
    Route::get('/authors/create', [AutherController::class, 'create'])->name('authors.create');
    Route::get('/authors/edit/{auther}', [AutherController::class, 'edit'])->name('authors.edit');
    Route::post('/authors/update/{id}', [AutherController::class, 'update'])->name('authors.update');
    Route::post('/authors/delete/{id}', [AutherController::class, 'destroy'])->name('authors.destroy');
    Route::post('/authors/create', [AutherController::class, 'store'])->name('authors.store');

    // publisher crud
    Route::get('/publishers', [PublisherController::class, 'index'])->name('publishers');
    Route::get('/publisher/create', [PublisherController::class, 'create'])->name('publisher.create');
    Route::get('/publisher/edit/{publisher}', [PublisherController::class, 'edit'])->name('publisher.edit');
    Route::post('/publisher/update/{id}', [PublisherController::class, 'update'])->name('publisher.update');
    Route::post('/publisher/delete/{id}', [PublisherController::class, 'destroy'])->name('publisher.destroy');
    Route::post('/publisher/create', [PublisherController::class, 'store'])->name('publisher.store');

    // Category CRUD
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::get('/category/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::post('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::post('/category/create', [CategoryController::class, 'store'])->name('category.store');




    // books CRUD
    Route::get('/books', [BookController::class, 'index'])->name('books');
    Route::get('/book/create', [BookController::class, 'create'])->name('book.create');
    Route::get('/book/edit/{book}', [BookController::class, 'edit'])->name('book.edit');
    Route::get('/book/show/{book}', [BookController::class, 'show'])->name('book.show');
    Route::post('/book/update/{id}', [BookController::class, 'update'])->name('book.update');
    Route::post('/book/delete/{id}', [BookController::class, 'destroy'])->name('book.destroy');
    Route::post('/book/create', [BookController::class, 'store'])->name('book.store');

    // students CRUD
    Route::get('/students', [StudentController::class, 'index'])->name('students');
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::get('/student/edit/{student}', [StudentController::class, 'edit'])->name('student.edit');
    Route::post('/student/update/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::post('/student/delete/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
    Route::post('/student/create', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student/show/{id}', [StudentController::class, 'show'])->name('student.show');



    Route::get('/book_issue', [BookIssueController::class, 'index'])->name('book_issued');
    Route::get('/book-issue/create', [BookIssueController::class, 'create'])->name('book_issue.create');
    Route::get('/book-issue/edit/{id}', [BookIssueController::class, 'edit'])->name('book_issue.edit');
    Route::post('/book-issue/update/{id}', [BookIssueController::class, 'update'])->name('book_issue.update');
    Route::post('/book-issue/delete/{id}', [BookIssueController::class, 'destroy'])->name('book_issue.destroy');
    Route::post('/book-issue/create', [BookIssueController::class, 'store'])->name('book_issue.store');


    Route::get('/broken-book', [BrokenBookController::class, 'index'])->name('broken-book');
    Route::get('/broken-book/create', [BrokenBookController::class, 'create'])->name('broken-book.create');
    Route::get('/broken-book/edit/{id}', [BrokenBookController::class, 'edit'])->name('broken-book.edit');
    Route::patch('/broken-book/update/{id}', [BrokenBookController::class, 'update'])->name('broken-book.update');
    Route::post('/broken-book/delete/{id}', [BrokenBookController::class, 'destroy'])->name('broken-book.destroy');
    Route::post('/broken-book/create', [BrokenBookController::class, 'store'])->name('broken-book.store');

    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
    Route::get('/reports/Date-Wise', [ReportsController::class, 'date_wise'])->name('reports.date_wise');
    Route::post('/reports/Date-Wise', [ReportsController::class, 'generate_date_wise_report'])->name('reports.date_wise_generate');
    Route::get('/reports/monthly-Wise', [ReportsController::class, 'month_wise'])->name('reports.month_wise');
    Route::post('/reports/monthly-Wise', [ReportsController::class, 'generate_month_wise_report'])->name('reports.month_wise_generate');
    Route::get('/reports/weekly-Wise', [ReportsController::class, 'week_wise'])->name('reports.week_wise');
    Route::post('/reports/weekly-Wise', [ReportsController::class, 'generate_week_wise_report'])->name('reports.week_wise_generate');
    Route::get('/reports/date-range', [ReportsController::class, 'date_range'])->name('reports.date_range');
    Route::post('/reports/date-range', [ReportsController::class, 'generate_date_range_report'])->name('reports.date_range_generate');
    Route::get('/reports/not-returned', [ReportsController::class, 'not_returned'])->name('reports.not_returned');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings');

    // Stock Take Routes
    Route::get('/stock-take', [App\Http\Controllers\StockTakeController::class, 'index'])->name('stock-take.index');
    Route::get('/stock-take/create', [App\Http\Controllers\StockTakeController::class, 'create'])->name('stock-take.create');
    Route::post('/stock-take', [App\Http\Controllers\StockTakeController::class, 'store'])->name('stock-take.store');
    Route::get('/stock-take/{stockTake}/count', [App\Http\Controllers\StockTakeController::class, 'count'])->name('stock-take.count');
    Route::post('/stock-take/{stockTake}/update-count', [App\Http\Controllers\StockTakeController::class, 'updateCount'])->name('stock-take.update-count');
    Route::post('/stock-take/{stockTake}/complete', [App\Http\Controllers\StockTakeController::class, 'complete'])->name('stock-take.complete');
    Route::get('/stock-take/{stockTake}', [App\Http\Controllers\StockTakeController::class, 'show'])->name('stock-take.show');
});
