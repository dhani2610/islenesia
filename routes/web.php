<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes (Company Profile - China, Europe & Indonesia)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('catalog')->name('catalog.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{slug}', [ProductController::class, 'show'])->name('show');
});

Route::get('/tentang-kami', [AboutController::class, 'index'])->name('about');

Route::prefix('kontak')->name('contact.')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::post('/', [ContactController::class, 'store'])->name('store')->middleware('throttle:10,1');
});

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
    Route::post('/{id}/like', [BlogController::class, 'like'])->name('like')->middleware('throttle:20,1');
    Route::post('/{id}/comment', [BlogController::class, 'comment'])->name('comment')->middleware('throttle:10,1');
});

use App\Http\Controllers\CaptchaController;

// Interactive WhatsApp Floating Modal submission (Buyer vs Petani)
Route::post('/inquiry/widget', [InquiryController::class, 'storeWidget'])->name('inquiry.widget')->middleware('throttle:15,1');

// Dynamic Anti-Bot Captcha Challenge
Route::get('/captcha/refresh', [CaptchaController::class, 'refresh'])->name('captcha.refresh');

// Storage Media Fallback (Provides seamless file serving on shared hosting where symlink() is disabled)
Route::get('/storage/{path}', function (string $path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    $mime = mime_content_type($filePath) ?: 'application/octet-stream';
    return response()->file($filePath, [
        'Content-Type' => $mime,
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->where('path', '.*')->name('storage.fallback');


/*
|--------------------------------------------------------------------------
| Secret Admin Authentication Portal (No public login button on website!)
|--------------------------------------------------------------------------
*/
Route::get('/portal-access', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/portal-access', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/portal-access/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::redirect('/login', '/portal-access');
Route::redirect('/admin/login', '/portal-access');


/*
|--------------------------------------------------------------------------
| Protected Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Leads & Inquiries
    Route::prefix('inquiries')->name('inquiries.')->group(function () {
        Route::get('/data', [AdminInquiryController::class, 'data'])->name('data');
        Route::get('/', [AdminInquiryController::class, 'index'])->name('index');
        Route::post('/{id}/status', [AdminInquiryController::class, 'updateStatus'])->name('status');
        Route::delete('/{id}', [AdminInquiryController::class, 'destroy'])->name('destroy');
    });

    // Products / Commodities
    Route::get('products/data', [AdminProductController::class, 'data'])->name('products.data');
    Route::resource('products', AdminProductController::class);

    // Catalog Categories (Kategori Produk / Komoditas)
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);

    // Blog Articles
    Route::get('posts/data', [AdminPostController::class, 'data'])->name('posts.data');
    Route::resource('posts', AdminPostController::class);

    // Comments Moderation
    Route::prefix('comments')->name('comments.')->group(function () {
        Route::get('/data', [AdminCommentController::class, 'data'])->name('data');
        Route::get('/', [AdminCommentController::class, 'index'])->name('index');
        Route::post('/{id}/toggle', [AdminCommentController::class, 'toggleApprove'])->name('toggle');
        Route::delete('/{id}', [AdminCommentController::class, 'destroy'])->name('destroy');
    });

    // Testimonials
    Route::get('testimonials/data', [AdminTestimonialController::class, 'data'])->name('testimonials.data');
    Route::resource('testimonials', AdminTestimonialController::class);

    // FAQs (Tanya Jawab)
    Route::get('faqs/data', [AdminFaqController::class, 'data'])->name('faqs.data');
    Route::resource('faqs', AdminFaqController::class);

    // Hero Sliders (Dynamic CRUD)
    Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class)->except(['show']);

    // Our Clients & Partners CMS
    Route::resource('clients', \App\Http\Controllers\Admin\ClientController::class)->except(['show']);
    Route::resource('partners', \App\Http\Controllers\Admin\PartnerController::class)->except(['show']);

    // Settings (Web Identity, Contacts, Dynamic Social Media, SEO, About Us Content)
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Profile & Password
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');

    // Admin Users Management (CRUD)
    Route::get('users/data', [\App\Http\Controllers\Admin\AdminUserController::class, 'data'])->name('users.data');
    Route::resource('users', \App\Http\Controllers\Admin\AdminUserController::class);

    // Interactive Manual Book & CMS Documentation
    Route::get('/manual-book', [\App\Http\Controllers\Admin\ManualBookController::class, 'index'])->name('manual-book.index');
});
