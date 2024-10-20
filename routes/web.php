<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleClassroomController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TelegramBotController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCourseController;
use App\Models\RoleClassroom;
use App\Models\UserCourse;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

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

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/telegram/webhook', [TelegramBotController::class, 'webhook']);
Route::post('/telegram/send-message', [TelegramBotController::class, 'sendCustomMessage']);

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('home');

    // Books routes
    Route::get('admin/library', [BookController::class, 'index'])->name('library');
    Route::get('admin/book/create', [BookController::class, 'create'])->name('book.create');
    Route::post('admin/book', [BookController::class, 'store'])->name('book.store');
    Route::get('admin/book/{id}', [BookController::class, 'edit'])->name('book.edit');
    Route::put('admin/book/{id}', [BookController::class, 'update'])->name('book.update');
    Route::delete('admin/book/{id}', [BookController::class, 'delete'])->name('book.delete');

    //Digital Library
    Route::get('admin/digital-library', [BookController::class, 'digitalLibrary'])->name('digital-library');

    //Categories routes
    Route::get('admin/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('admin/categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::get('admin/categories/category/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('admin/categories/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::post('admin/categories/category', [CategoryController::class, 'store'])->name('category.store');
    Route::delete('admin/categories/category/{id}', [CategoryController::class, 'delete'])->name('category.delete');
    Route::post('admin/categories/category', [CategoryController::class, 'storeAjax'])->name('category.store-ajax');

    //Loan routes
    Route::get('admin/loans', [LoanController::class, 'index'])->name('loans');
    Route::get('admin/loans/create', [LoanController::class, 'create'])->name('loan.create');
    Route::get('admin/loans/loan/return/{id}', [LoanController::class, 'return'])->name('loan.return');
    Route::get('admin/loans/loan/extendMin/{id}', [LoanController::class, 'extendMin'])->name('loan.extendMin');
    Route::get('admin/loans/loan/extendMax/{id}', [LoanController::class, 'extendMax'])->name('loan.extendMax');
    Route::put('admin/loans/loan/{id}', [LoanController::class, 'update'])->name('loan.update');
    Route::post('admin/loans/loan', [LoanController::class, 'store'])->name('loan.store');
    Route::delete('admin/loans/loan/{id}', [LoanController::class, 'delete'])->name('loan.delete');

    //Courses routes
    Route::get('admin/courses', [CourseController::class, 'index'])->name('courses');
    Route::get('admin/courses/create', [CourseController::class, 'create'])->name('course.create');
    Route::post('admin/courses/course', [CourseController::class, 'store'])->name('course.store');
    Route::get('admin/courses/course/{id}', [CourseController::class, 'edit'])->name('course.edit');
    Route::put('admin/courses/course/{id}', [CourseController::class, 'update'])->name('course.update');
    Route::delete('admin/courses/course/{id}', [CourseController::class, 'delete'])->name('course.delete');
    Route::get('admin/courses/view/{id}', [CourseController::class, 'view'])->name('course.view');

    //Subjects routes
    Route::get('admin/{id}/subjects', [SubjectController::class, 'create'])->name('subject.create');
    Route::post('admin/subjects/subject', [SubjectController::class, 'store'])->name('subject.store');
    Route::get('admin/subjects/subject/{id}', [SubjectController::class, 'edit'])->name('subject.edit');
    Route::put('admin/subjects/subject/{id}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('admin/subjects/subject/{id}', [SubjectController::class, 'delete'])->name('subject.delete');
    Route::get('admin/subjects/check-code/{code}', [SubjectController::class, 'checkCode'])->name('subject.check-code');
    Route::get('admin/subject/view/{id}', [SubjectController::class, 'view'])->name('subject.view');

    //Students routes
    Route::post('admin/course/students', [UserCourseController::class, 'enroll'])->name('students.enroll');
    Route::delete('admin/course/{courseId}/student/{studentId}', [UserCourseController::class, 'delete'])->name('student.delete');
    Route::post('admin/subject/students', [RoleClassroomController::class, 'enroll'])->name('students.subject.enroll');
    Route::delete('admin/subject/{subjectId}/student/{studentId}', [RoleClassroomController::class, 'delete'])->name('student.subject.delete');

    //Roles routes
    Route::get('admin/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('admin/roles/create', [RoleController::class, 'create'])->name('role.create');
    Route::get('admin/roles/role/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('admin/roles/role/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::post('admin/roles/role', [RoleController::class, 'store'])->name('role.store');
    Route::delete('admin/roles/role/{id}', [RoleController::class, 'delete'])->name('role.delete');



    Route::middleware(['isAdminOrLibrarian'])->group(function () {
        //Users routes
        Route::get('admin/users', [UserController::class, 'index'])->name('users');
        Route::get('admin/users/create', [UserController::class, 'create'])->name('user.create');
        Route::get('admin/users/user/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('admin/users/user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::post('admin/users/user', [UserController::class, 'store'])->name('user.store');
        Route::delete('admin/users/user/{id}', [UserController::class, 'delete'])->name('user.delete');
    });

    Route::middleware(['isAdmin'])->group(function () {
        //Permission Routes
        Route::get('admin/permissions', [PermissionController::class, 'index'])->name('permissions');
        Route::get('admin/permissions/create', [PermissionController::class, 'create'])->name('permission.create');
        Route::get('admin/permissions/permission/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::put('admin/permissions/permission/{id}', [PermissionController::class, 'update'])->name('permission.update');
        Route::post('admin/permissions/permission', [PermissionController::class, 'store'])->name('permission.store');
        Route::delete('admin/permissions/permission/{id}', [PermissionController::class, 'delete'])->name('permission.delete');
    });
});
Route::get('/', function () {
    return redirect('/login');
});

