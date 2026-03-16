<?php

use App\Http\Controllers\{Auth\Github\CallbackController,
    Auth\Github\RedirectController,
    DashboardController,
    ProfileController,
    QuestionController};

use App\Http\Controllers\Question;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //    if (app()->isLocal()) {
    //        auth()->loginUsingId(1);
    //
    //        return to_route('dashboard');
    //    }

    return view('auth.login');
});

Route::get('/github/login', RedirectController::class)->name('github.login');
Route::get('/github/callback', CallbackController::class)->name('github.callback');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    #region Profiles Routes

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    #endregion

    #region Question Routes

    Route::prefix('/question')->name('question.')->group(function () {
        Route::get('/index', [QuestionController::class, 'index'])->name('index');
        Route::post('/store', [QuestionController::class, 'store'])->name('store');
        Route::post('/like/{question}', Question\LikeController::class)->name('like');
        Route::post('/unlike/{question}', Question\UnlikeController::class)->name('unlike');
        Route::put('/publish/{question}', Question\PublishController::class)->name('publish');
        Route::delete('/destroy/{question}', [QuestionController::class, 'destroy'])->name('destroy');
        Route::patch('/archive/{question}', [QuestionController::class, 'archive'])->name('archive');
        Route::patch('/restore/{question}', [QuestionController::class, 'restore'])->name('restore');
        Route::get('/edit/{question}', [QuestionController::class, 'edit'])->name('edit');
        Route::put('/update/{question}', [QuestionController::class, 'update'])->name('update');
    });
    #endregion
});

require __DIR__ . '/auth.php';
