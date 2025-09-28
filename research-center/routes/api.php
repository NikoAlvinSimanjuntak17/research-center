<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\DatasetApiController;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\CouponApiController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\CheckoutApiController;
use App\Http\Controllers\Api\OrderApiController;





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/preview/{filename}', [DatasetApiController::class, 'preview']);

// Route::post('/post-login', [AuthApiController::class, 'postLogin'])->name('post-login');
// Route::post('/post-registration', [AuthApiController::class, 'postRegistration'])->name('post-registration');

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/post-logout', [AuthApiController::class, 'logout'])->name('logout');
//     Route::get('/me', [AuthApiController::class, 'me']);
// });

Route::middleware('auth:sanctum')->group(function () {

    // Sama seperti web.php
    Route::get('/dataset/index', [DatasetApiController::class, 'index'])->name('dataset.index');            // List dataset (admin)
    Route::get('/dataset/data-index', [DatasetApiController::class, 'dataIndex'])->name('dataset.data-index'); // Datatable JSON
    Route::post('/dataset/store', [DatasetApiController::class, 'store'])->name('dataset.store');            // Create dataset
    Route::get('/dataset/edit/{id}', [DatasetApiController::class, 'edit'])->name('dataset.edit');           // Ambil 1 data
    Route::put('/dataset/update/{id}', [DatasetApiController::class, 'update'])->name('dataset.update');     // Update dataset
    Route::delete('/dataset/destroy/{id}', [DatasetApiController::class, 'destroy'])->name('dataset.destroy');  // Hapus dataset
    Route::get('/dataset/detail/{id}', [DatasetApiController::class, 'show'])->name('dataset.detail');       // Detail dataset
    Route::get('/dataset/download/{id}', [DatasetApiController::class, 'download'])->name('dataset.download.direct'); // Download ZIP

    // Frontend versi API (untuk customer)
    Route::get('/frontend-dataset/index', [DatasetApiController::class, 'frontendIndex'])->name('frontend-dataset.index');
    Route::get('/frontend-dataset/view/{id}', [DatasetApiController::class, 'frontendShow'])->name('frontend-dataset.view');
});

Route::prefix('event')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [EventApiController::class, 'index'])->name('event.index');
    Route::get('/create', [EventApiController::class, 'create'])->name('event.create');
    Route::post('/store', [EventApiController::class, 'store'])->name('event.store');
    Route::get('/{id}/edit', [EventApiController::class, 'edit'])->name('event.edit');
    Route::post('/{id}/update', [EventApiController::class, 'update'])->name('event.update');
    Route::delete('/{id}/delete', [EventApiController::class, 'destroy'])->name('event.destroy');
    Route::get('/verified-participants', [EventApiController::class, 'verifiedParticipants'])->name('event.verified');
    Route::post('/upload-certificate/{id}', [EventApiController::class, 'uploadCertificate'])->name('event.uploadCertificate');
    Route::get('/certificate/download/{event_registration_id}', [EventApiController::class, 'downloadCertificate']);

});

Route::prefix('frontend-event')->group(function () {
    Route::get('/index', [EventApiController::class, 'frontendIndex'])->name('frontend-event.index');
    Route::get('/view/{id}', [EventApiController::class, 'view'])->name('frontend-event.view');
});


Route::prefix('coupon')->middleware('auth:sanctum')->name('coupon.')->group(function () {
    Route::get('/index', [CouponApiController::class, 'index'])->name('index');
    Route::get('/data-index', [CouponApiController::class, 'dataIndex'])->name('dataIndex');
    Route::post('/store', [CouponApiController::class, 'store'])->name('store');
    Route::get('/show/{id}', [CouponApiController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [CouponApiController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [CouponApiController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [CouponApiController::class, 'destroy'])->name('destroy');
});
Route::prefix('cart')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\CartApiController::class, 'index']);
    Route::post('/add/{id}', [\App\Http\Controllers\Api\CartApiController::class, 'add']);
    Route::delete('/remove/{id}', [\App\Http\Controllers\Api\CartApiController::class, 'remove']);
    Route::post('/apply-coupon', [\App\Http\Controllers\Api\CartApiController::class, 'applyCoupon']);
});
Route::middleware('auth:sanctum')->prefix('checkout')->group(function () {
    Route::get('/show', [CheckoutApiController::class, 'show']);
    Route::post('/place-order', [CheckoutApiController::class, 'placeOrder']);
});

Route::post('/midtrans/callback', [CheckoutApiController::class, 'handleMidtransNotification']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders', [OrderApiController::class, 'index']);
    Route::get('/orders/{id}/download-dataset', [OrderApiController::class, 'downloadDataset']);
    Route::post('/orders/{order}/review', [OrderApiController::class, 'submitReview']);
    Route::post('/event/verify-token', [OrderApiController::class, 'verifyAttendanceToken']);
    Route::get('/orders/{order}/invoice', [OrderApiController::class, 'downloadInvoice']);
    Route::get('/orders/export/excel', [OrderApiController::class, 'exportExcel']);
});

