<?php

use Illuminate\Support\Facades\Route;
use App\View\Components\ReportForm;





// routes/web.php
use App\Http\Controllers\NotificationController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\ProfileSetupController;
use App\Http\Controllers\UserController;

Route::get('auth/{provider}/redirect', [SocialiteController::class, 'redirectToProvider']);
Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);


use App\Http\Controllers\FileExplorerController;
use App\Http\Controllers\CourseController;


use App\Http\Controllers\SchoolController;


use App\Http\Controllers\ChangeRequestController;

use App\Http\Controllers\VideoSessionController;


use App\Http\Controllers\BookingController;
use App\Http\Controllers\AppointmentController;
use App\Models\Appointment;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DynamicContentController;
use App\Http\Controllers\PageContentController;
use Illuminate\Http\Request;

Route::post('/update-record', [DynamicContentController::class, 'update']);

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {







        Route::post('/save-report', [ReportForm::class, 'saveReport'])->name('report.save');

        Route::post('/send-notification', [NotificationController::class, 'sendNotification'])->name('send-data');

        // routes/web.php


        Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');

        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


        Route::get('/', function () {
            return view('welcome');
        })->name('home');
        Route::get('/about-us', function () {
            return view('about');
        });
        Route::get('/contact', function () {
            return view('contact');
        });



        Route::prefix('/dashboard')->group(function () {


            Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments');

            Route::get('/session/{id}', [VideoSessionController::class, 'showSession'])
                ->name('session');

            Route::post('/session/{id}/signal', [VideoSessionController::class, 'signal'])
                ->name('session.signal');










Route::get('chat',function(){
    return view('chat');
});

                Route::get('/usersss', [ChatController::class, 'getUsers'])->name('usersss.index');
                Route::post('/conversations', [ChatController::class, 'createConversation'])->name('conversations.create');
                Route::get('/conversations', [ChatController::class, 'getUserConversations'])->name('conversations.index');
                Route::post('/messages', [ChatController::class, 'sendMessage'])->name('messages.store');
                Route::get('/messages/{conversation}', [ChatController::class, 'getMessages'])->name('messages.show');
                Route::post('/conversations/groups', [ChatController::class, 'createGroup'])->name('conversations.groups.create');
                Route::get('/groups', [ChatController::class, 'getGroups'])->name('groups.index');



            Route::get('/calendar/{teacher}', [AppointmentController::class, 'show'])->name('calendar.show');
            Route::post('/calendar/book', [AppointmentController::class, 'book'])->name('calendar.book');
            Route::get('/calendar/events/{teacher}', [AppointmentController::class, 'fetchEvents'])->name('calendar.events');
            Route::post('/calendar/delete', [AppointmentController::class, 'delete'])->name('calendar.delete');
            Route::post('/calendar/update', [AppointmentController::class, 'update'])->name('calendar.edit');






            Route::resource('courses', CourseController::class);

            Route::post('/change-request', [ChangeRequestController::class, 'store'])->name('change-request.store');
            Route::post('/change-request/{id}/approve', [ChangeRequestController::class, 'approve'])->name('change-request.approve');
            Route::post('/change-request/{id}/reject', [ChangeRequestController::class, 'reject'])->name('change-request.reject');


            Route::get('/file-explorer', [FileExplorerController::class, 'index'])->name('file.explorer');
            Route::post('/file-explorer/delete', [FileExplorerController::class, 'delete'])->name('file.delete');



            Route::resource('schools', SchoolController::class);
            Route::get('schools/{school}/education/create', [SchoolController::class, 'createEducation'])->name('schools.education.create');
            Route::post('schools/{school}/education', [SchoolController::class, 'storeEducation'])->name('schools.education.store');


            Route::get('/reports', function () {
                return view('dashboard.reports');
            })->name('reports');

            Route::get('/', [ProfileSetupController::class, 'showForm'])->name('profile.setup');



            Route::post('/user/update-profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
        })->middleware('auth');
    }
);
