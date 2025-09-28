<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\DatasetContoller;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Ordercontroller;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudyCentreController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\CartController;
use App\Notifications\AdminNotification;
use App\Http\Controllers\Researcher\AdminResearcherController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ResearchFacilityController;
use App\Http\Controllers\CommodityController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GalleryFileController;
use App\Http\Controllers\Researcher\ResearcherController;
use App\Http\Controllers\Researcher\PublicationController;
use App\Http\Controllers\Researcher\ResearcherProjectController;
use App\Http\Controllers\Researcher\ResearcherProjectCollaboratorController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\Researcher\JoinProjectController;
use App\Http\Controllers\AllPublicationController;
use App\Http\Controllers\UserPublicationController;
use App\Http\Controllers\CollaboratorApplicationController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Researcher\ResearcherDashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['id', 'en'])) {
        abort(400);
    }

    session(['locale' => $locale]); // simpan ke session
    return back(); // redirect kembali
})->name('set.locale');

Route::get('/', function () {
    return view('index');
})->name('index');

Route::controller(DatasetContoller::class)->group(function () {

Route::get('/preview-image/{filename}', 'show')
        ->where('filename', '.*'); // agar bisa menangani nama file yang mengandung titik (seperti .pdf)
});

Route::post('/ckeditor/upload', [App\Http\Controllers\CKEditorController::class, 'upload'])->name('ckeditor.upload');
Route::delete('/ckeditor/delete', [App\Http\Controllers\CKEditorController::class, 'delete'])->name('ckeditor.delete');


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/post-login', [AuthController::class, 'postLogin'])->name('post-login');
Route::get('/registration', [AuthController::class, 'registration'])->name('register');
Route::post('/post-registration', [AuthController::class, 'postRegistration'])->name('post-registration');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/post-logout', [AuthController::class, 'logout'])->name('post-logout');
Route::post('/midtrans/callback', [CheckoutController::class, 'handleMidtransNotification']);
Route::post('/admin/notifications/mark-as-read', [AdminController::class, 'markNotificationsAsRead'])->name('admin.notifications.markAsRead');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Admin Area
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Researcher Area
Route::middleware(['auth', 'role:researcher'])->group(function () {
    Route::get('/researcher/dashboard', [ResearcherDashboardController::class, 'index'])->name('researcher.dashboard');
});

Route::group(['prefix' => 'user/profile', 'middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\UserProfileController::class, 'show'])->name('user.profile.show');
    Route::get('/edit', [App\Http\Controllers\UserProfileController::class, 'edit'])->name('user.profile.edit');
    Route::post('/update', [App\Http\Controllers\UserProfileController::class, 'update'])->name('user.profile.update');
});
Route::group(['prefix' => 'slider', 'middleware' => 'auth'], function () {
    Route::get('/index', [SliderController::class, 'index'])->name('slider.index');
    Route::get('/data-index', [SliderController::class, 'dataIndex'])->name('slider.data-index');
    Route::get('/create', [SliderController::class, 'create'])->name('slider.create');
    Route::post('/store', [SliderController::class, 'store'])->name('slider.store');
    Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');
    Route::put('/update/{id}', [SliderController::class, 'update'])->name('slider.update');
    Route::get('/destroy/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
});

Route::group(['prefix' => 'news', 'middleware' => 'auth'], function () {
    Route::get('/index', [NewsController::class, 'index'])->name('news.index');
    Route::get('/data-index', [NewsController::class, 'dataIndex'])->name('news.data-index');
    Route::post('/store', [NewsController::class, 'store'])->name('news.store');
    Route::get('/create', [NewsController::class, 'create'])->name('news.create');
    Route::get('/edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/update/{id}', [NewsController::class, 'update'])->name('news.update');
    Route::get('/destroy/{id}', [NewsController::class, 'destroy'])->name('news.destroy');
    Route::get('/show/{id}', [NewsController::class, 'show'])->name('news.show');

});
Route::group(['prefix' => 'dataset', 'middleware' => 'auth'], function () {
    Route::get('/index', [DatasetContoller::class, 'index'])->name('dataset.index');
    Route::get('/data-index', [DatasetContoller::class, 'dataIndex'])->name('dataset.data-index');
    Route::get('/create', [DatasetContoller::class, 'create'])->name('dataset.create');
    Route::post('/store', [DatasetContoller::class, 'store'])->name('dataset.store');
    Route::get('/edit/{id}', [DatasetContoller::class, 'edit'])->name('dataset.edit');
    Route::put('/update/{id}', [DatasetContoller::class, 'update'])->name('dataset.update');
    Route::get('/destroy/{id}', [DatasetContoller::class, 'destroy'])->name('dataset.destroy');

});
Route::get('/dataset/detail/{id}', [DatasetContoller::class, 'detail'])->name('dataset.detail');
Route::get('/dataset/download/{id}', [DatasetContoller::class, 'downloadDirect'])->name('dataset.download.direct');

Route::group(['prefix' => 'event', 'middleware' => 'auth'], function () {
    Route::get('/', [EventController::class, 'index'])->name('event.index');
    Route::get('/create', [EventController::class, 'create'])->name('event.create');
    Route::post('/store', [EventController::class, 'store'])->name('event.store');
    Route::get('/{id}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::put('/{id}/update', [EventController::class, 'update'])->name('event.update');
    Route::delete('/{id}/delete', [EventController::class, 'destroy'])->name('event.destroy');
    Route::get('/verified-participants', [EventController::class, 'verifiedParticipants'])->name('event.verified');
    Route::post('/upload-certificate/{id}', [EventController::class, 'uploadCertificate'])->name('event.uploadCertificate');
});

Route::group(['prefix' => 'admission', 'middleware' => 'auth'], function () {
    Route::get('/index', [AdmissionController::class, 'index'])->name('admission.index');
    Route::get('/data-index', [AdmissionController::class, 'dataIndex'])->name('admission.data-index');
    Route::post('/store', [AdmissionController::class, 'store'])->name('admission.store');
    Route::get('/create', [AdmissionController::class, 'create'])->name('admission.create');
    Route::get('/edit/{id}', [AdmissionController::class, 'edit'])->name('admission.edit');
    Route::put('/update/{id}', [AdmissionController::class, 'update'])->name('admission.update');
    Route::get('/destroy/{id}', [AdmissionController::class, 'destroy'])->name('admission.destroy');
    Route::get('/show/{id}', [AdmissionController::class, 'show'])->name('admission.show');

});

Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {
    Route::get('/index', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/data-index', [ProfileController::class, 'dataIndex'])->name('profile.data-index');
    Route::post('/store', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::get('/edit/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/destroy/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/show/{id}', [ProfileController::class, 'show'])->name('profile.show');
});

Route::group(['prefix' => 'study-centre', 'middleware' => 'auth'], function () {
    Route::get('/index', [StudyCentreController::class, 'index'])->name('study-centre.index');
    Route::get('/data-index', [StudyCentreController::class, 'dataIndex'])->name('study-centre.data-index');
    Route::post('/store', [StudyCentreController::class, 'store'])->name('study-centre.store');
    Route::get('/create', [StudyCentreController::class, 'create'])->name('study-centre.create');
    Route::get('/edit/{id}', [StudyCentreController::class, 'edit'])->name('study-centre.edit');
    Route::put('/update/{id}', [StudyCentreController::class, 'update'])->name('study-centre.update');
    Route::get('/destroy/{id}', [StudyCentreController::class, 'destroy'])->name('study-centre.destroy');
    Route::get('/show/{id}', [StudyCentreController::class, 'show'])->name('study-centre.show');
});

Route::group(['prefix' => 'community', 'middleware' => 'auth'], function () {
    Route::get('/index', [CommunityController::class, 'index'])->name('community.index');
    Route::get('/data-index', [CommunityController::class, 'dataIndex'])->name('community.data-index');
    Route::post('/store', [CommunityController::class, 'store'])->name('community.store');
    Route::get('/create', [CommunityController::class, 'create'])->name('community.create');
    Route::get('/edit/{id}', [CommunityController::class, 'edit'])->name('community.edit');
    Route::put('/update/{id}', [CommunityController::class, 'update'])->name('community.update');
    Route::get('/destroy/{id}', [CommunityController::class, 'destroy'])->name('community.destroy');
    Route::get('/show/{id}', [CommunityController::class, 'show'])->name('community.show');

});

Route::group(['prefix' => 'study-program', 'middleware' => 'auth'], function () {
    Route::get('/index', [StudyProgramController::class, 'index'])->name('study-program.index');
    Route::get('/data-index', [StudyProgramController::class, 'dataIndex'])->name('study-program.data-index');
    Route::post('/store', [StudyProgramController::class, 'store'])->name('study-program.store');
    Route::get('/create', [StudyProgramController::class, 'create'])->name('study-program.create');
    Route::get('/edit/{id}', [StudyProgramController::class, 'edit'])->name('study-program.edit');
    Route::put('/update/{id}', [StudyProgramController::class, 'update'])->name('study-program.update');
    Route::get('/destroy/{id}', [StudyProgramController::class, 'destroy'])->name('study-program.destroy');
    Route::get('/show/{id}', [StudyProgramController::class, 'show'])->name('study-program.show');
});

Route::group(['prefix' => 'announcement', 'middleware' => 'auth'], function () {
    Route::get('/index', [AnnouncementController::class, 'index'])->name('announcement.index');
    Route::get('/data-index', [AnnouncementController::class, 'dataIndex'])->name('announcement.data-index');
    Route::post('/store', [AnnouncementController::class, 'store'])->name('announcement.store');
    Route::get('/create', [AnnouncementController::class, 'create'])->name('announcementm.create');
    Route::get('/edit/{id}', [AnnouncementController::class, 'edit'])->name('announcement.edit');
    Route::put('/update/{id}', [AnnouncementController::class, 'update'])->name('announcement.update');
    Route::get('/destroy/{id}', [AnnouncementController::class, 'destroy'])->name('announcement.destroy');
    Route::get('/show/{id}', [AnnouncementController::class, 'show'])->name('announcement.show');
});

Route::group(['prefix' => 'lecturer', 'middleware' => 'auth'], function () {
    Route::get('/index', [LecturerController::class, 'index'])->name('lecturer.index');
    Route::get('/data-index', [LecturerController::class, 'dataIndex'])->name('lecturer.data-index');
    Route::post('/store', [LecturerController::class, 'store'])->name('lecturer.store');
    Route::get('/create', [LecturerController::class, 'create'])->name('lecturer.create');
    Route::get('/edit/{id}', [LecturerController::class, 'edit'])->name('lecturer.edit');
    Route::put('/update/{id}', [LecturerController::class, 'update'])->name('lecturer.update');
    Route::get('/destroy/{id}', [LecturerController::class, 'destroy'])->name('lecturer.destroy');
    Route::get('/show/{id}', [LecturerController::class, 'show'])->name('lecturer.show');
});

Route::group(['prefix' => 'cart'], function () {
    Route::get('/', [CartController::class, 'index'])->name('frontend-cart.index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('frontend-cart.add');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('frontend-cart.remove');
    Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('frontend-cart.applyCoupon');
});
Route::group(['prefix' => 'checkout', 'middleware' => 'auth'], function () {
    Route::get('/checkout', [CheckoutController::class, 'showCheckoutPage'])->name('frontend-checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('frontend-checkout.placeOrder');
});

Route::group(['prefix' => 'order', 'middleware' => 'auth'], function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('frontend-orders.index');
    Route::get('/order/{id}/download', [OrderController::class, 'downloadDataset'])->name('frontend-orders.download')->middleware('auth');
    Route::get('/orders/{order}/review', [OrderController::class, 'showReviewForm'])->name('frontend-orders.review');
    Route::post('/orders/{order}/review', [OrderController::class, 'submitReview'])->name('frontend-orders.submitReview');
    Route::post('/event/verify-token', [OrderController::class, 'verifyAttendanceToken'])->name('frontend-events.verifyToken');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('frontend-orders.invoice')->middleware('auth');
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::get('/orders/export', [OrderController::class, 'exportExcel'])->name('admin.orders.export');
});

Route::group(['prefix' => 'admin/researcher', 'middleware' => 'auth'], function () {
    Route::get('/index', [AdminResearcherController::class, 'index'])->name('researcher.index');
    Route::get('/create', [AdminResearcherController::class, 'create'])->name('researcher.create');
    Route::post('/store', [AdminResearcherController::class, 'store'])->name('researcher.store');
    Route::get('/show/{id}', [AdminResearcherController::class, 'show'])->name('researcher.show');
    Route::get('/destroy/{id}', [AdminResearcherController::class, 'destroy'])->name('researcher.destroy');
    Route::get('/data-index', [AdminResearcherController::class, 'dataIndex'])->name('researcher.data-index');
});

Route::group(['prefix' => 'admin/institution', 'as' => 'admin.institutions.', 'middleware' => 'auth'], function () {
    Route::get('/index', [InstitutionController::class, 'index'])->name('index');
    Route::get('/create', [InstitutionController::class, 'create'])->name('create');
    Route::post('/store', [InstitutionController::class, 'store'])->name('store');
    Route::get('/show/{id}', [InstitutionController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [InstitutionController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [InstitutionController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [InstitutionController::class, 'destroy'])->name('destroy');
    Route::get('/data-index', [InstitutionController::class, 'dataIndex'])->name('data-index');
});

Route::group(['prefix' => 'admin/department', 'as' => 'admin.department.', 'middleware' => 'auth'], function () {
    Route::get('/index', [DepartmentController::class, 'index'])->name('index');
    Route::get('/create', [DepartmentController::class, 'create'])->name('create');
    Route::post('/store', [DepartmentController::class, 'store'])->name('store');
    Route::get('/edit/{department}', [DepartmentController::class, 'edit'])->name('edit');
    Route::put('/update/{department}', [DepartmentController::class, 'update'])->name('update');
    Route::delete('/destroy/{department}', [DepartmentController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'admin/research-facility', 'as' => 'admin.research-facility.', 'middleware' => 'auth'], function () {
    Route::get('/index', [ResearchFacilityController::class, 'index'])->name('index');
    Route::get('/create', [ResearchFacilityController::class, 'create'])->name('create');
    Route::post('/store', [ResearchFacilityController::class, 'store'])->name('store');
    Route::get('/edit/{research_facility}', [ResearchFacilityController::class, 'edit'])->name('edit');
    Route::put('/update/{research_facility}', [ResearchFacilityController::class, 'update'])->name('update');
    Route::delete('/destroy/{research_facility}', [ResearchFacilityController::class, 'destroy'])->name('destroy');
    Route::get('/show/{research_facility}', [ResearchFacilityController::class, 'show'])->name('show'); // <-- Ini dia
});

Route::group(['prefix' => 'admin/commodity', 'as' => 'admin.commodity.', 'middleware' => 'auth'], function () {
    Route::get('/index', [CommodityController::class, 'index'])->name('index');
    Route::get('/create', [CommodityController::class, 'create'])->name('create');
    Route::post('/store', [CommodityController::class, 'store'])->name('store');
    Route::get('/edit/{commodity}', [CommodityController::class, 'edit'])->name('edit');
    Route::put('/update/{commodity}', [CommodityController::class, 'update'])->name('update');
    Route::delete('/destroy/{commodity}', [CommodityController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'admin/partnership', 'as' => 'admin.partnership.', 'middleware' => 'auth'], function () {
    Route::get('/index', [PartnershipController::class, 'index'])->name('index');
    Route::get('/create', [PartnershipController::class, 'create'])->name('create');
    Route::post('/store', [PartnershipController::class, 'store'])->name('store');
    Route::get('/edit/{partnership}', [PartnershipController::class, 'edit'])->name('edit');
    Route::put('/update/{partnership}', [PartnershipController::class, 'update'])->name('update');
    Route::delete('/destroy/{partnership}', [PartnershipController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
    Route::get('/galleries', [GalleryController::class, 'index'])->name('galleries.index');
    Route::get('/galleries/create', [GalleryController::class, 'create'])->name('galleries.create');
    Route::post('/galleries', [GalleryController::class, 'store'])->name('galleries.store');
    Route::get('/galleries/{gallery}/edit', [GalleryController::class, 'edit'])->name('galleries.edit');
    Route::put('/galleries/{gallery}', [GalleryController::class, 'update'])->name('galleries.update');
    Route::delete('/galleries/{gallery}', [GalleryController::class, 'destroy'])->name('galleries.destroy');

    Route::get('/gallery_files', [GalleryFileController::class, 'index'])->name('gallery_files.index');
    Route::get('/gallery_files/create', [GalleryFileController::class, 'create'])->name('gallery_files.create');
    Route::post('/gallery_files', [GalleryFileController::class, 'store'])->name('gallery_files.store');
    Route::get('/gallery_files/{gallery_file}/edit', [GalleryFileController::class, 'edit'])->name('gallery_files.edit');
    Route::put('/gallery_files/{gallery_file}', [GalleryFileController::class, 'update'])->name('gallery_files.update');
    Route::delete('/gallery_files/{gallery_file}', [GalleryFileController::class, 'destroy'])->name('gallery_files.destroy');

});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('projects/{id}/approve', [ProjectController::class, 'approve'])->name('projects.approve');
    Route::post('projects/{id}/reject', [ProjectController::class, 'reject'])->name('projects.reject');
    Route::get('projects/collaborators', [ProjectController::class, 'showCollaborators'])->name('projects.collaborators.index');
    Route::get('projects/{project}/collaborators/{user}', [ProjectController::class, 'showCollaboratorDetail'])->name('projects.collaborators.show');
    Route::put('projects/{projectId}/collaborators/{userId}/status', [ProjectController::class, 'updateCollaboratorStatus'])->name('projects.collaborators.update-status');
    Route::delete('projects/{projectId}/collaborators/{userId}', [ProjectController::class, 'removeCollaborator'])->name('projects.collaborators.remove');
    Route::get('projects/{projectId}/collaborators/pending/count', [ProjectController::class, 'pendingCount'])->name('projects.collaborators.pending-count');
});

Route::group(['prefix' => 'admin/collaborators', 'as' => 'admin.collaborators.', 'middleware' => 'auth'], function () {
    Route::get('/', [CollaboratorController::class, 'index'])->name('index');
    Route::get('/{id}', [CollaboratorController::class, 'show'])->name('show');
    Route::post('/{id}/approve', [CollaboratorController::class, 'approve'])->name('approve');
    Route::post('/{id}/reject', [CollaboratorController::class, 'reject'])->name('reject');
    Route::post('/{id}/make-leader', [CollaboratorController::class, 'makeLeader'])->name('make-leader');
    Route::get('/{id}/download-cv', [CollaboratorController::class, 'downloadCV'])->name('download-cv');
});

Route::group(['prefix' => 'admin/publications', 'as' => 'admin.publications.', 'middleware' => 'auth'], function () {
    Route::get('/', [AllPublicationController::class, 'index'])->name('index');
    Route::get('/{id}', [AllPublicationController::class, 'show'])->name('show');
});


Route::group(['prefix' => 'researcher/profile', 'as' => 'researcher.profile.', 'middleware' => 'auth'], function () {
    Route::get('/show', [ResearcherController::class, 'showProfile'])->name('show');
    Route::get('/edit', [ResearcherController::class, 'editProfile'])->name('edit');
    Route::post('/update', [ResearcherController::class, 'updateProfile'])->name('updateProfile');
});

Route::group(['prefix' => 'researcher', 'as' => 'researcher.', 'middleware' => 'auth'], function () {
    Route::get('/publications', [PublicationController::class, 'index'])->name('publications');
    Route::post('/publications/sync/{researcherId}', [PublicationController::class, 'syncPublications'])->name('publications.sync');
});

Route::group(['prefix' => 'researcher', 'as' => 'researcher.', 'middleware' => ['auth']], function () {

    // Route untuk kolaborator - LETAKKAN DI AWAL
    Route::get('projects/collaborators', [ResearcherProjectCollaboratorController::class, 'index'])->name('projects.collaborators.index');
    Route::get('projects/{projectId}/collaborators/{userId}', [ResearcherProjectCollaboratorController::class, 'show'])->name('projects.collaborators.show');
    Route::put('projects/{projectId}/collaborators/{userId}/status', [ResearcherProjectCollaboratorController::class, 'updateCollaboratorStatus'])->name('projects.collaborators.update-status');
    Route::delete('projects/{projectId}/collaborators/{userId}', [ResearcherProjectCollaboratorController::class, 'removeCollaborator'])->name('projects.collaborators.remove');

    // Route untuk join project
    Route::get('join-projects', [JoinProjectController::class, 'index'])->name('projects.join.index');
    Route::post('join-projects/{project}/join', [JoinProjectController::class, 'join'])->name('projects.join.request');
    Route::delete('join-projects/{project}/leave', [JoinProjectController::class, 'leave'])->name('projects.join.leave');

    // Route project CRUD
    Route::get('projects', [ResearcherProjectController::class, 'index'])->name('projects.index');
    Route::get('projects/create', [ResearcherProjectController::class, 'create'])->name('projects.create');
    Route::post('projects', [ResearcherProjectController::class, 'store'])->name('projects.store');

    // PENTING! Letakkan route dinamis PALING BAWAH
    Route::get('projects/{id}/submit-publication', [ResearcherProjectController::class, 'submitPublication'])->name('projects.submit-publication');
    Route::post('projects/{id}/store-publication', [ResearcherProjectController::class, 'storePublication'])->name('projects.store-publication');
    Route::get('projects/{id}', [ResearcherProjectController::class, 'show'])->name('projects.show');
    Route::get('projects/{id}/edit', [ResearcherProjectController::class, 'edit'])->name('projects.edit');
    Route::put('projects/{id}', [ResearcherProjectController::class, 'update'])->name('projects.update');
    Route::delete('projects/{id}', [ResearcherProjectController::class, 'destroy'])->name('projects.destroy');
});


Route::group(['prefix' => 'frontend-admission'], function () {
    Route::get('/view/{id}', [AdmissionController::class, 'view'])->name('frontend-admission.view');
});

Route::group(['prefix' => 'frontend-news'], function () {
    Route::get('/view/{id}', [NewsController::class, 'view'])->name('frontend-news.view');
    Route::get('/index', [NewsController::class, 'frontendIndex'])->name('frontend-news.index');

});
Route::group(['prefix' => 'frontend-dataset'], function () {
    Route::get('/view/{id}', [DatasetContoller::class, 'view'])->name('frontend-dataset.view');
    Route::get('/index', [DatasetContoller::class, 'frontendIndex'])->name('frontend-dataset.index');

});
Route::group(['prefix' => 'frontend-event'], function () {
    Route::get('/view/{id}', [EventController::class, 'view'])->name('frontend-event.view');
    Route::get('/index', [EventController::class, 'frontendIndex'])->name('frontend-event.index');

});


Route::group(['prefix' => 'frontend-profile'], function () {
    Route::get('view/{id?}', [ProfileController::class, 'view'])->name('frontend-profile.view');
    Route::get('/sambutan', [ProfileController::class, 'sambutan'])->name('frontend-profile.sambutan');
    Route::get('/visi-misi', [ProfileController::class, 'visiMisi'])->name('frontend-profile.visiMisi');
    Route::get('/struktur-organisasi', [ProfileController::class, 'strukturOrganisasi'])->name('frontend-profile.struktur');

});

Route::group(['prefix' => 'frontend-study-centre'], function () {
    Route::get('/view/{id}', [StudyCentreController::class, 'view'])->name('frontend-study-centre.view');
});

Route::group(['prefix' => 'frontend-community'], function () {
    Route::get('/view/{id}', [CommunityController::class, 'view'])->name('frontend-community.view');
});

Route::group(['prefix' => 'frontend-study-program'], function () {
    Route::get('/view/{id}', [StudyProgramController::class, 'view'])->name('frontend-study-program.view');
});

Route::group(['prefix' => 'frontend-announcement'], function () {
    Route::get('/view/{id}', [AnnouncementController::class, 'view'])->name('frontend-announcement.view');
    Route::get('/index', [AnnouncementController::class, 'frontendIndex'])->name('frontend-announcement.index');

});

Route::group(['prefix' => 'frontend-lecturer'], function () {
    Route::get('/view/{id}', [LecturerController::class, 'view'])->name('frontend-lecturer.view');
    Route::get('/index', [LecturerController::class, 'frontendIndex'])->name('frontend-lecturer.index');
});

Route::group(['prefix' => 'frontend-komoditas'], function () {
    Route::get('/index', [CommodityController::class, 'indexFrontend'])->name('frontend-komoditas.index');
    Route::get('/view/{id}', [CommodityController::class, 'view'])->name('frontend-komoditas.view');
});

Route::group(['prefix' => 'frontend-facility'], function () {
    Route::get('/index', [ResearchFacilityController::class, 'indexFrontend'])->name('frontend-fasilitas.index');
    Route::get('/view/{id}', [ResearchFacilityController::class, 'view'])->name('frontend-fasilitas.view');
});
Route::group(['prefix' => 'frontend-partnership'], function () {
    Route::get('/index', [PartnershipController::class, 'indexFrontend'])->name('frontend-partnership.index');
    Route::get('/view/{id}', [PartnershipController::class, 'view'])->name('frontend-partnership.view');
});

Route::prefix('frontend-researchers')->name('frontend-researchers.')->group(function () {
    Route::get('/index', [UserPublicationController::class, 'listResearchers'])->name('list');
    Route::get('/detail/{researcher}', [UserPublicationController::class, 'showResearcherDetail'])->name('detail');
});

Route::prefix('frontend-publication')->name('frontend-publication.')->group(function () {
    Route::get('/index', [UserPublicationController::class, 'index'])->name('index');
    Route::get('/fetch', [UserPublicationController::class, 'fetchPublications'])->name('fetch');
    Route::get('/researcher/{researcher}', [UserPublicationController::class, 'showByResearcher'])->name('byresearcher');
    Route::get('/search/byresearcher', [UserPublicationController::class, 'search'])->name('search');
});
Route::group(['prefix' => 'admin/profile', 'middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\AdminProfileController::class, 'show'])->name('admin.profile.show');
    Route::get('/edit', [App\Http\Controllers\AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::post('/update', [App\Http\Controllers\AdminProfileController::class, 'update'])->name('admin.profile.update');
});

Route::prefix('frontend-project')->name('frontend-project.')->group(function () {
    // Daftar dan detail proyek publik
    Route::get('/index', [ProjectController::class, 'indexfrontend'])->name('index');
    Route::get('/show/{id}', [ProjectController::class, 'show'])->name('show');

    // Form dan simpan apply kolaborator (auth wajib login)
    Route::middleware(['auth'])->group(function () {
        Route::get('/apply/{project}', [CollaboratorApplicationController::class, 'create'])->name('apply');
        Route::post('/apply/{project}', [CollaboratorApplicationController::class, 'store'])->name('apply.store');
    });
});

Route::prefix('frontend-gallery')->name('frontend-gallery.')->group(function () {
    Route::get('/index', [GalleryFileController::class, 'indexFrontend'])->name('index');
    Route::get('/{gallery}', [GalleryFileController::class, 'showFrontend'])->name('show');
});

Route::group(['prefix' => 'coupon', 'as' => 'coupon.', 'middleware' => 'auth'], function () {
    Route::get('/index', [CouponController::class, 'index'])->name('index');
    Route::get('/create', [CouponController::class, 'create'])->name('create');
    Route::post('/store', [CouponController::class, 'store'])->name('store');
    Route::get('/show/{id}', [CouponController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [CouponController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [CouponController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [CouponController::class, 'destroy'])->name('destroy');
    Route::get('/data-index', [CouponController::class, 'dataIndex'])->name('dataIndex');
});



Route::group(['prefix' => 'admin/contact', 'as' => 'contact.', 'middleware' => 'auth'], function () {
    Route::get('/index', [ContactController::class, 'index'])->name('index');
    Route::get('/create', [ContactController::class, 'create'])->name('create');
    Route::post('/store', [ContactController::class, 'store'])->name('store');
    Route::get('/show/{contact}', [ContactController::class, 'show'])->name('show');
    Route::get('/edit/{contact}', [ContactController::class, 'edit'])->name('edit');
    Route::put('/update/{contact}', [ContactController::class, 'update'])->name('update');
    Route::delete('/destroy/{contact}', [ContactController::class, 'destroy'])->name('destroy');
});

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');