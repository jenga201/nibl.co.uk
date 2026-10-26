<?php

use App\Http\Controllers\BotController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/bots', [BotController::class, 'index'])->name('bots');
Route::get('/bots/{name}', [BotController::class, 'show'])->name('bot');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/search', [SearchController::class, 'index'])->name('search');
