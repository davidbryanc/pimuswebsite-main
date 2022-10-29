<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

// // Coming Soon page
// Route::get('/', function () {
//     return view('comingsoon');
// });

Route::get('/', function () {
    return view('index');
})->name('index');

// Route tipe get yang digunakan saat mengakses halaman
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/registration/cabang/register', function () {
        return view('registerlomba');
    });
    Route::post('/registration/cabang/upload', 'RegisterLomba@upload');
    Route::get('/submission', 'SubmissionController@index')->name('submission');
    Route::post('submitlink', "SubmissionController@submitLink")->name('submitlink');
    Route::post('/exhibition/{id}/vote', 'ExhibitionController@vote')->name('exhibition.vote');
    Route::get('/registration/cabang/register', 'RegisterLomba@showRegister');
    
    Route::group(['middleware' => ['admin']], function () {
        
        // admin route
        Route::prefix('admin')->group(function () {
            // admin index
            Route::get('', [AdminController::class, 'index'])->name('admin.index');

            // admin account
            Route::get('/accounts', [AdminController::class, 'accounts'])->name('admin.accounts');
            Route::post('/editUser', [AdminController::class, 'editUser'])->name('admin.editUser');
            Route::post('/deleteUser', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');

            // admin group
            Route::get('/groups', [AdminController::class, 'groups'])->name('admin.groups');
            Route::get('/specialCase', [AdminController::class, 'specialCase'])->name('admin.specialCase');
            Route::post('/addGroup', [AdminController::class, 'addGroup'])->name('admin.addGroup');
            Route::post('/editGroup', [AdminController::class, 'editGroup'])->name('admin.editGroup');

            // admin submissions
            Route::get('/submissions', [AdminController::class, 'submissions'])->name('admin.submissions');
            Route::post('/editSubmissions', [AdminController::class, 'updateSubmissions'])->name('admin.editSubmissions');
            Route::post('/deleteSubmissions', [AdminController::class, 'deleteSubmissions'])->name('admin.deleteSubmissions');
            Route::post('/addSubmission', [AdminController::class, 'addSubmission'])->name('admin.addSubmission');
        });
    });
});

Auth::routes(['verify' => true]);
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/aboutus', function () {
    return view('aboutus');
});

Route::get('/registration/cabang', 'RegisterLomba@showCabang');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/registration', 'RegisterLomba@showRegistration');

Route::get('/exhibition/{idlomba}', 'ExhibitionController@index')->name('exhibition');

Route::get('/exhibitioncoba', function () {
    return view('exhibitioncoba');
});

