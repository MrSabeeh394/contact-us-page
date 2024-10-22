<?php

use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('contact-us', [EmailController::class, 'viewContactUs']);
Route::post('submitContactUs', [EmailController::class, 'submitContactUs'])->name('contactform');
