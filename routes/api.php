<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarEventController;
use App\Http\Controllers\EventTypeController;

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


/*
|--------------------------------------------------------------------------
| Auth APIs
|--------------------------------------------------------------------------
|
|
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});


/*
|--------------------------------------------------------------------------
| Event APIs
|--------------------------------------------------------------------------
|
|
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/events', [CalendarEventController::class, 'getEvent']);
    Route::post('/events', [CalendarEventController::class, 'createNewEvent']);
    Route::put('/events', [CalendarEventController::class, 'updateEvent']);
    Route::delete('/events', [CalendarEventController::class, 'deleteEvent']);
});

/*
|--------------------------------------------------------------------------
| Event Type APIs
|--------------------------------------------------------------------------
|
|
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/event-type', [EventTypeController::class, 'getEventTypes']);
    Route::post('/event-type', [EventTypeController::class, 'createNewEventType']);
    Route::put('/event-type', [EventTypeController::class, 'updateEventType']);
    Route::delete('/event-type/{id}', [EventTypeController::class, 'deleteEventType']);
});