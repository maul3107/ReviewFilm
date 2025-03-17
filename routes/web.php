<?php

use App\Http\Controllers\User\HomeController as HomeController;
use App\Http\Controllers\Author\DashboardController as AuthorDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FilmController as AdminFilmController;
use App\Http\Controllers\Author\FilmController as AuthorFilmController;
use App\Http\Controllers\Admin\GenreController as AdminGenreController;
use App\Http\Controllers\Admin\GenreRelationController as AdminGenreRelationController;
use App\Http\Controllers\Author\GenreRelationController as AuthorGenreRelationController;
use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\CastingController as AdminCastingController;
use App\Http\Controllers\Author\CastingController as AuthorCastingController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\User\CommentController as UserCommentController;
use App\Http\Controllers\User\DetailFilmController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\User\SemuaFilmController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('dashboard');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');



// Comment Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/store-comment', [UserCommentController::class, 'store'])->name('store-comment');
    Route::put('/update-comment/{id}', [UserCommentController::class, 'update'])->name('update-comment');
    Route::delete('/delete-comment/{id}', [UserCommentController::class, 'destroy'])->name('delete-comment');
});

// Film
Route::get('/detail-film/{id}', [DetailFilmController::class, 'detailFilm'])->name('detail-film');
Route::get('/semua-film', [SemuaFilmController::class, 'pencarianFilm'])->name('semua-film');
Route::get('/api/search', [SemuaFilmController::class, 'apiSearch']);

// Detail Genre (Bisa diakses semua user)
Route::get('/genre/{slug}', [AdminGenreController::class, 'detailGenre'])->name('detail-genre');

// Route Role Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminIndexController::class, 'index'])->name('index');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/genre', [AdminGenreController::class, 'index'])->name('genre.index');
    Route::get('/genre-relation', [AdminGenreRelationController::class, 'index'])->name('genre-relation.index');
    Route::get('/casting', [AdminCastingController::class, 'index'])->name('casting.index');
    Route::get('/comment', [AdminCommentController::class, 'index'])->name('comment.index');
    Route::get('/user', [AdminUserController::class, 'index'])->name('user.index');

    // Film Admin
    Route::get('/film', [AdminFilmController::class, 'index'])->name('film.index');
    Route::get('/create-film', [AdminFilmController::class, 'create'])->name('create-film');
    Route::post('/store-film', [AdminFilmController::class, 'store'])->name('store-film');
    Route::get('/edit-film/{id}', [AdminFilmController::class, 'edit'])->name('edit-film');
    Route::put('/update-film/{id}', [AdminFilmController::class, 'update'])->name('update-film');
    Route::delete('/delete-film/{id}', [AdminFilmController::class, 'destroy'])->name('delete-film');

    // Genre Admin
    Route::get('/genre/{slug}', [AdminGenreController::class, 'detailGenre'])->name('detail-genre');
    Route::get('/create-genre', [AdminGenreController::class, 'create'])->name('create-genre');
    Route::post('/store-genre', [AdminGenreController::class, 'store'])->name('store-genre');
    Route::get('/edit-genre/{id}', [AdminGenreController::class, 'edit'])->name('edit-genre');
    Route::put('/update-genre/{id}', [AdminGenreController::class, 'update'])->name('update-genre');
    Route::delete('/delete-genre/{id}', [AdminGenreController::class, 'destroy'])->name('delete-genre');

    // Genre Relation Admin
    Route::get('/create-genre-relation', [AdminGenreRelationController::class, 'create'])->name('create-genre-relation');
    Route::post('/store-genre-relation', [AdminGenreRelationController::class, 'store'])->name('store-genre-relation');
    Route::get('/edit-genre-relation/{id}', [AdminGenreRelationController::class, 'edit'])->name('edit-genre-relation');
    Route::put('/update-genre-relation/{id}', [AdminGenreRelationController::class, 'update'])->name('update-genre-relation');
    Route::delete('/delete-genre-relation/{id}', [AdminGenreRelationController::class, 'destroy'])->name('delete-genre-relation');

    // Casting Admin
    Route::get('/create-casting', [AdminCastingController::class, 'create'])->name('create-casting');
    Route::post('/store-casting', [AdminCastingController::class, 'store'])->name('store-casting');
    Route::get('/edit-casting/{id}', [AdminCastingController::class, 'edit'])->name('edit-casting');
    Route::put('/update-casting/{id}', [AdminCastingController::class, 'update'])->name('update-casting');
    Route::delete('/delete-casting/{id}', [AdminCastingController::class, 'destroy'])->name('delete-casting');

    // Comment Admin
    Route::get('/create-comment', [AdminCommentController::class, 'create'])->name('create-comment');
    Route::post('/store-comment', [AdminCommentController::class, 'store'])->name('store-comment');
    Route::get('/edit-comment/{id}', [AdminCommentController::class, 'edit'])->name('edit-comment');
    Route::put('/update-comment/{id}', [AdminCommentController::class, 'update'])->name('update-comment');
    Route::delete('/delete-comment/{id}', [AdminCommentController::class, 'destroy'])->name('delete-comment');

    // User Admin
    Route::get('/create-user', [AdminUserController::class, 'create'])->name('create-user');
    Route::post('/store-user', [AdminUserController::class, 'store'])->name('store-user');
    Route::get('/edit-user/{id}', [AdminUserController::class, 'edit'])->name('edit-user');
    Route::put('/update-user/{id}', [AdminUserController::class, 'update'])->name('update-user');
    Route::delete('/delete-user/{id}', [AdminUserController::class, 'destroy'])->name('delete-user');
});

// Route Role Author
Route::middleware(['auth', 'role:author'])->prefix('author')->name('author.')->group(function () {
    Route::get('/', [AdminIndexController::class, 'index'])->name('index');
    Route::get('/dashboard', [AuthorDashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/genre-relation', [AuthorGenreRelationController::class, 'index'])->name('genre-relation.index');
    Route::get('/casting', [AuthorCastingController::class, 'index'])->name('casting.index');


    // Film Author
    Route::get('/film', [AuthorFilmController::class, 'index'])->name('film.index');
    Route::get('/create-film', [AuthorFilmController::class, 'create'])->name('create-film');
    Route::post('/store-film', [AuthorFilmController::class, 'store'])->name('store-film');
    Route::get('/edit-film/{id}', [AuthorFilmController::class, 'edit'])->name('edit-film');
    Route::put('/update-film/{id}', [AuthorFilmController::class, 'update'])->name('update-film');
    Route::delete('/delete-film/{id}', [AuthorFilmController::class, 'destroy'])->name('delete-film');

    // Genre Relation Author
    Route::get('/create-genre-relation', [AuthorGenreRelationController::class, 'create'])->name('create-genre-relation');
    Route::post('/store-genre-relation', [AuthorGenreRelationController::class, 'store'])->name('store-genre-relation');
    Route::get('/edit-genre-relation/{id}', [AuthorGenreRelationController::class, 'edit'])->name('edit-genre-relation');
    Route::put('/update-genre-relation/{id}', [AuthorGenreRelationController::class, 'update'])->name('update-genre-relation');
    Route::delete('/delete-genre-relation/{id}', [AuthorGenreRelationController::class, 'destroy'])->name('delete-genre-relation');

    // Casting Author
    Route::get('/create-casting', [AuthorCastingController::class, 'create'])->name('create-casting');
    Route::post('/store-casting', [AuthorCastingController::class, 'store'])->name('store-casting');
    Route::get('/edit-casting/{id}', [AuthorCastingController::class, 'edit'])->name('edit-casting');
    Route::put('/update-casting/{id}', [AuthorCastingController::class, 'update'])->name('update-casting');
    Route::delete('/delete-casting/{id}', [AuthorCastingController::class, 'destroy'])->name('delete-casting');

});

// Route Role Author
Route::middleware(['auth', 'role:author'])->prefix('author')->name('author.')->group(function () {
    Route::get('/home', [AuthorDashboardController::class, 'index'])->name('dashboard.index');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
