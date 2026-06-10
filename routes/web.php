<?php

use App\Http\Controllers\Admin\OfferController as AdminOfferController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdvertiserEnquiryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OnboardingAgreementController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ComplianceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/advertisers', [PageController::class, 'advertisers'])->name('advertisers');
Route::get('/advertisers/enquiry', [AdvertiserEnquiryController::class, 'create'])->name('advertiser.enquiry');
Route::post('/advertisers/enquiry', [AdvertiserEnquiryController::class, 'store'])->name('advertiser.enquiry.store');
Route::get('/publishers', [PageController::class, 'publishers'])->name('publishers');
Route::get('/offers', [OffersController::class, 'index'])->name('offers');
Route::get('/verticals', [PageController::class, 'verticals'])->name('verticals');
Route::get('/about', [PageController::class, 'about'])->name('about');

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/apply', [ApplicationController::class, 'create'])->name('apply');
Route::post('/apply', [ApplicationController::class, 'store'])->name('apply.store');
Route::get('/apply/success', [ApplicationController::class, 'success'])->name('apply.success');

Route::get('/onboarding/publisher', [OnboardingController::class, 'createPublisher'])->name('onboarding.publisher');
Route::post('/onboarding/publisher', [OnboardingController::class, 'storePublisher'])->name('onboarding.publisher.store');
Route::get('/onboarding/publisher/agreement', [OnboardingAgreementController::class, 'createPublisher'])->name('onboarding.publisher.agreement');
Route::post('/onboarding/publisher/agreement', [OnboardingAgreementController::class, 'storePublisher'])->name('onboarding.publisher.agreement.store');
Route::get('/onboarding/advertiser', [OnboardingController::class, 'createAdvertiser'])->name('onboarding.advertiser');
Route::post('/onboarding/advertiser', [OnboardingController::class, 'storeAdvertiser'])->name('onboarding.advertiser.store');
Route::get('/onboarding/advertiser/agreement', [OnboardingAgreementController::class, 'createAdvertiser'])->name('onboarding.advertiser.agreement');
Route::post('/onboarding/advertiser/agreement', [OnboardingAgreementController::class, 'storeAdvertiser'])->name('onboarding.advertiser.agreement.store');
Route::get('/onboarding/complete', [OnboardingAgreementController::class, 'success'])->name('onboarding.agreement.success');

Route::redirect('/login', '/partner/login');

Route::middleware('guest')->group(function () {
    Route::get('/partner/login', [LoginController::class, 'createPartner'])->name('partner.login');
    Route::post('/partner/login', [LoginController::class, 'storePartner'])->name('partner.login.store');
    Route::get('/partner/password/forgot', [PasswordResetController::class, 'createPartner'])->name('partner.password.request');
    Route::post('/partner/password/forgot', [PasswordResetController::class, 'storePartner'])->name('partner.password.request.store');
    Route::get('/partner/password/sent', [PasswordResetController::class, 'sentPartner'])->name('partner.password.sent');

    Route::get('/advertiser/login', [LoginController::class, 'createAdvertiser'])->name('advertiser.login');
    Route::post('/advertiser/login', [LoginController::class, 'storeAdvertiser'])->name('advertiser.login.store');
    Route::get('/advertiser/password/forgot', [PasswordResetController::class, 'createAdvertiser'])->name('advertiser.password.request');
    Route::post('/advertiser/password/forgot', [PasswordResetController::class, 'storeAdvertiser'])->name('advertiser.password.request.store');
    Route::get('/advertiser/password/sent', [PasswordResetController::class, 'sentAdvertiser'])->name('advertiser.password.sent');
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/privacy', [LegalController::class, 'privacy'])->name('privacy');
Route::get('/terms', [LegalController::class, 'terms'])->name('terms');
Route::get('/affiliate-agreement', [LegalController::class, 'affiliateAgreement'])->name('affiliate-agreement');
Route::get('/advertiser-agreement', [LegalController::class, 'advertiserAgreement'])->name('advertiser-agreement');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('offers', AdminOfferController::class)->except(['show']);
});

Route::middleware('compliance')->prefix('compliance')->name('compliance.')->group(function () {
    Route::get('/', [ComplianceController::class, 'index'])->name('index');
    Route::get('/reviews/{review}', [ComplianceController::class, 'show'])->name('show');
    Route::post('/reviews/{review}', [ComplianceController::class, 'update'])->name('update');
});
