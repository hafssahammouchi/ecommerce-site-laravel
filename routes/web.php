<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Public & Auth
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// Boutique
Route::get('/boutique', [ShopController::class, 'index'])->name('shop.index');
Route::get('/boutique/categorie/{slug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/boutique/produit/{slug}', [ShopController::class, 'product'])->name('shop.product');
Route::post('/boutique/produit/{product}/avis', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');

// Panier
Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier/ajouter/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/panier/modifier', [CartController::class, 'update'])->name('cart.update');
Route::post('/panier/retirer/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Commande & livraison
Route::get('/commander', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/commander', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/commande/{order}/paiement', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/commande/{order}/paiement', [CheckoutController::class, 'pay'])->name('checkout.pay');
Route::get('/commande/{order}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

// Pages entreprise
Route::get('/a-propos', [PageController::class, 'about'])->name('about');
Route::get('/categories', [PageController::class, 'categories'])->name('categories.index');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'contactStore'])->name('contact.store');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/livraison-retours', [PageController::class, 'shipping'])->name('shipping');
Route::get('/mentions-legales', [PageController::class, 'legal'])->name('legal');
Route::post('/newsletter', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/compte/commandes', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/favoris', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/favoris/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/favoris/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::get('contact', [ContactMessageController::class, 'index'])->name('contact.index');
    Route::get('contact/{contact}', [ContactMessageController::class, 'show'])->name('contact.show');
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});
