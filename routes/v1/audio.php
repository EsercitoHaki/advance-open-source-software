<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AudioController;

// Routes không cần xác thực để phát audio
// Không dùng middleware jwt.auth cho các route này
Route::get('audio/question/{questionId}', [AudioController::class, 'streamAudio'])->name('audio.question');
Route::get('audio/file/{filename}', [AudioController::class, 'streamAudioFile'])->name('audio.file');
