<?php

use App\Http\Controllers\AssessmentController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DoctorProfileController;
use App\Livewire\AdminRegister;
use App\Livewire\DoctorList;
use App\Livewire\DoctorRegister;
use App\Livewire\UserList;

Route::get('/', function () {
    return view('frontend.home.index');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profille');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    //  Volt::route('settings/appearance1', 'settings.appearance1')->name('settings.appearance1');
    


    // Route::get('users',UserList::class)->middleware('admin')->name('users.index');
});


Route::middleware(['auth', 'verified', 'admin', ])->group(function () {
    Route::get('users', UserList::class)->name('users.index');
    Route::get('doctors', DoctorList::class)->name('doctors.index');
});


Route::middleware(['auth', 'verified', 'doctor'])->group(function () {
    Route::get('users', UserList::class)->name('users.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('doctors', DoctorList::class)->name('doctors.index');
});


Route::view('admin/dashboard', 'admin.dashboard')
    ->middleware(['auth', 'verified','admin'])
    ->name('admin.dashboard');


    Route::view('doctor/dashboard', 'doctor.dashboard')
    ->middleware(['auth', 'verified','doctor'])
    ->name('doctor.dashboard');


    Route::middleware(['auth','admin'])->group(function()
    {
        Route::get('/admin/register',AdminRegister::class)->name('admin.register');
    });

     Route::middleware(['auth','admin'])->group(function()
    {
        Route::get('/doctor/register',DoctorRegister::class)->name('doctor.register');
    });


Route::controller(FaqController::class)->group(function () {
    // Publicly accessible route
    Route::get('faqs', 'index')->name('faqs.index');

    // Authenticated and verified routes
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('faqs/create', 'create')->name('faqs.create');
        Route::post('faqs', 'store')->name('faqs.store');
        Route::get('faqs/{faq:slug}/edit', 'edit')->name('faqs.edit');
        Route::put('faqs/{faq:slug}', 'update')->name('faqs.update');
        Route::delete('faqs/{faq:slug}', 'destroy')->name('faqs.destroy');
    });
});


Route::prefix('ourteam')->group(function () {
    
    Route::get('/create', [TeamMemberController::class, 'create'])->name('ourteam.create');
    Route::post('/store', [TeamMemberController::class, 'store'])->name('ourteam.store');
    Route::get('/{teamMember}/edit', [TeamMemberController::class, 'edit'])->name('ourteam.edit');
    Route::put('/{teamMember}', [TeamMemberController::class, 'update'])->name('ourteam.update');
    Route::delete('/{teamMember}', [TeamMemberController::class, 'destroy'])->name('ourteam.destroy');
});
// Abou
Route::get('/team', [TeamMemberController::class, 'index'])->name('team.index');

Route::get('/assessment', [AssessmentController::class, 'index'])
    ->name('assessment.index')->middleware('auth');
    
Route::middleware(['auth'])->group(function () {
    Route::get('/assessment/{category}', [AssessmentController::class, 'show'])->name('assessment.show');
    Route::post('/responses', [ResponseController::class, 'store'])->name('responses.store');
    Route::get('/assessment/{category}/result', [ResponseController::class, 'result'])->name('assessment.result');
});
Route::get('/contact',[ContactController::class,'contact'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'submitContactForm'])->name('contact.send');

Route::middleware(['auth', 'doctor'])->group(function () {
    Route::get('/doctor/profile/edit', [DoctorProfileController::class, 'edit'])->name('doctor.profile.edit');
    Route::put('/doctor/profile/update', [DoctorProfileController::class, 'update'])->name('doctor.profile.update');
});

Route::get('/doctor', [DoctorProfileController::class, 'index'])->name('doctor.profile.index');
Route::get('/doctor/profile/{id}', [DoctorProfileController::class, 'show'])->name('doctor.profile.show');




require __DIR__.'/auth.php';
