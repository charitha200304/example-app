<?php

use App\Models\Job;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/about', [App\Http\Controllers\AboutController::class, 'showAboutPage'])->name('about');

Route::get('/jobs',function() {
    return  view('jobs',[
        'jobs' => Job::all()
    ]);
});

Route::get('/jobs/{id}',function($id){

        $job = Job::find($id);

    return  view('job',['job' => $job]);
});

require __DIR__.'/settings.php';
