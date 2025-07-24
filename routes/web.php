<?php

use App\Http\Controllers\Admin\IllnessCategoryController;
use App\Http\Controllers\Admin\IllnessCategoryDetailController;
use App\Http\Controllers\AssessmentController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\ContactController;
use App\Livewire\AdminRegister;
use App\Livewire\Chat;
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


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('users', UserList::class)->name('users.index');
    Route::get('doctors', DoctorList::class)->name('doctors.index');
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

Route::get('/team', [TeamMemberController::class, 'index'])->name('team.index');

// about us route
Route::get('/about', function () {
    return view('frontend.about.index');
})->name('about.index');

Route::get('/assessment', [AssessmentController::class, 'index'])
    ->name('assessment.index')->middleware('auth');
    
    
Route::middleware(['auth'])->group(function () {
    Route::get('/assessment/{category}', [AssessmentController::class, 'show'])->name('assessment.show');
    Route::post('/responses', [ResponseController::class, 'store'])->name('responses.store');
    Route::get('/assessment/{category}/result', [ResponseController::class, 'result'])->name('assessment.result');
});
Route::get('/contact',[ContactController::class,'contact'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'submitContactForm'])->name('contact.send');

Route::get('/anxiety', function () {
    return view('anxiety.index');
})->name('anxiety');

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->controller(IllnessCategoryController::class)
    ->group(function () {
        // Illness Categories Routes
        Route::get('illness-categories', 'index')->name('illness-categories.index');
        Route::get('illness-categories/create', 'create')->name('illness-categories.create');
        Route::post('illness-categories', 'store')->name('illness-categories.store');
        Route::get('illness-categories/{illnessCategory}/edit', 'edit')->name('illness-categories.edit');
        Route::put('illness-categories/{illnessCategory}', 'update')->name('illness-categories.update');
        Route::delete('illness-categories/{illnessCategory}', 'destroy')->name('illness-categories.destroy');
        Route::get('illness-categories/{illnessCategory}',  'show')->name('illness-categories.show');
    });

    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Illness Category Details
    Route::get('illness-categories/{illnessCategory}/details/create', [IllnessCategoryDetailController::class, 'create'])
        ->name('illness-categories.details.create');
    Route::post('illness-categories/{illnessCategory}/details', [IllnessCategoryDetailController::class, 'store'])
        ->name('illness-categories.details.store');
    Route::get('illness-categories/{illnessCategory}/details/edit', [IllnessCategoryDetailController::class, 'edit'])
        ->name('illness-categories.details.edit');
    Route::put('illness-categories/{illnessCategory}/details', [IllnessCategoryDetailController::class, 'update'])
        ->name('illness-categories.details.update');
});

Route::get('chat',Chat::class)->name('chat');

// use App\Livewire\JitsiMeeting;

use App\Livewire\JitsiMeeting;

Route::get('/meeting/{room?}', JitsiMeeting::class)->name('jitsi.meeting');
require __DIR__.'/auth.php';
