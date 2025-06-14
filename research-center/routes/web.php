<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PublicationController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Researchers\ResearcherController;
use App\Http\Controllers\Buyer\BuyerController;
use Illuminate\Http\Request;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\DatasetController;
use App\Http\Controllers\aboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminResearcherController;
use App\Http\Controllers\API\PublicationSyncController;
use App\Http\Controllers\Researchers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PublicationController as AdminPublication;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\HelpController;
use App\Http\Controllers\Admin\OrganizationStructureController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\UserPublicationController;
use App\Http\Controllers\Admin\InstitutionController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\CollaboratorController;
use App\Http\Controllers\GuestProjectController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\GalleryController as PublicGalleryController;
use App\Http\Controllers\CollaboratorApplicationController;
use App\Http\Controllers\Researchers\ResearcherProjectController;
use App\Http\Controllers\Researchers\ResearcherProjectCollaboratorController;
use App\Http\Controllers\Researchers\JoinProjectController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\PublicNewsController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\GalleryFileController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\AdminSliderController;

// routes/web.php
Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'id'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    app()->setLocale($locale);
    return redirect()->back();
});


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
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
//     Route::get('/user', function (Request $request) {
//         return response()->json($request->user());
//     });
// });

Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');

Route::middleware(['web'])->group(function () {
    Route::post('/login', [WebAuthController::class, 'login'])->name('login.post');
});
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

Route::get('/profile', [WebAuthController::class, 'showProfile'])->name('profile')->middleware('auth');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});


Route::get('/', function () {
    return view('welcome');
});


// Route untuk menampilkan halaman tanpa login
Route::post('/register', [BuyerController::class, 'registerBuyer'])->name('register');
Route::get('/register', [BuyerController::class, 'showRegisterForm'])->name('register.buyer');
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/about/sejarah', [AboutController::class, 'sejarah'])->name('sejarah');
Route::get('/about/visimisi', [AboutController::class, 'visimisi'])->name('visimisi');
Route::get('/about/organisasi', [AboutController::class, 'organisasi'])->name('organisasi');
Route::get('/contact', [ContactController::class, 'contactForm'])->name('contact');
Route::get('/galleries', [PublicGalleryController::class, 'publicIndex'])->name('galleries');

Route::get('/publications', [UserPublicationController::class, 'index'])->name('publications.index');
Route::get('/search-publications', [UserPublicationController::class, 'search'])->name('publications.search');
Route::get('/publications/{researcher}', [UserPublicationController::class, 'showByResearcher'])->name('publications.byresearcher');
Route::get('/researchers', [UserPublicationController::class, 'listResearchers'])->name('researchers');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/statistik', [UserPublicationController::class, 'statistik'])->name('statistik');
Route::get('/affiliations', [UserPublicationController::class, 'showAffiliations'])->name('affiliation');
Route::get('/affiliations/{institution}', [UserPublicationController::class, 'showInstitutionDetail'])->name('affiliations.detail');
Route::get('/department/{department}', [UserPublicationController::class, 'showDepartmentDetail'])->name('department.detail');
Route::get('/institutions/{id}/departments', [UserPublicationController::class, 'showdept'])->name('department');

Route::get('/projects/guest', [GuestProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{id}', [GuestProjectController::class, 'show'])->name('projects.show');


Route::get('/berita', [PublicNewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slugOrId}', [PublicNewsController::class, 'show'])->name('shownews');

Route::get('/', [HomeController::class, 'index']);




// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    // Resource route utk manajemen peneliti
    Route::get('/researchers', [AdminResearcherController::class, 'index'])->name('admin.researchers.index');
    Route::get('/researchers/create', [AdminResearcherController::class, 'create'])->name('admin.researchers.create');
    Route::post('/researchers', [AdminResearcherController::class, 'store'])->name('admin.researchers.store');
    Route::get('/researchers/{id}', [AdminResearcherController::class, 'show'])->name('admin.researchers.show');
    Route::delete('/researchers/{id}', [AdminResearcherController::class, 'destroy'])->name('admin.researchers.destroy');
    Route::post('/researchers/{id}/approve', [AdminResearcherController::class, 'approve'])->name('admin.researchers.approve');
    Route::get('/researchers/{id}/edit', [AdminResearcherController::class, 'edit'])->name('admin.researchers.edit');
    Route::put('/researchers/{id}', [AdminResearcherController::class, 'update'])->name('admin.researchers.update');

    // Optional: halaman permintaan approve
    Route::get('/researcher-requests', [AdminResearcherController::class, 'requests'])->name('admin.researchers.requests');
});

Route::prefix('admin/publications')->name('admin.publications.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminPublication::class, 'index'])->name('index');
    Route::get('/{id}', [AdminPublication::class, 'show'])->name('show');
    Route::post('/{id}/approve', [AdminPublication::class, 'approve'])->name('approve');
    Route::post('/{id}/reject', [AdminPublication::class, 'reject'])->name('reject');
});


// Structure_Organization routes
Route::prefix('admin/organizationstructure')->name('admin.organization.')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/', [OrganizationStructureController::class, 'index'])->name('index');
        Route::get('/create', [OrganizationStructureController::class, 'create'])->name('create');
        Route::post('/', [OrganizationStructureController::class, 'store'])->name('store');
        Route::get('/{organizationStructure}', [OrganizationStructureController::class, 'show'])->name('show');
        Route::get('/{organizationStructure}/edit', [OrganizationStructureController::class, 'edit'])->name('edit');
        Route::put('/{organizationStructure}', [OrganizationStructureController::class, 'update'])->name('update');
        Route::delete('/{organizationStructure}', [OrganizationStructureController::class, 'destroy'])->name('destroy');
    });


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('history', HistoryController::class);
    Route::resource('profiles', AdminProfileController::class);
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::post('ckeditor/upload', [App\Http\Controllers\Admin\CKEditorController::class, 'upload'])->name('ckeditor.upload');
});
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::resource('contacts', AdminContactController::class);
});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/visimisi', [VisiMisiController::class, 'index'])->name('visimisi.index');
    Route::get('/visimisi/create', [VisiMisiController::class, 'create'])->name('visimisi.create');
    Route::post('/visimisi', [VisiMisiController::class, 'store'])->name('visimisi.store');
    Route::get('/visimisi/edit', [VisiMisiController::class, 'edit'])->name('visimisi.edit');
    Route::put('/visimisi/update', [VisiMisiController::class, 'update'])->name('visimisi.update');
    Route::delete('/visimisi/{type}', [VisiMisiController::class, 'destroy'])->name('visimisi.destroy');
});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class)->except(['create', 'store']);
});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('roles', RoleController::class)->except(['create', 'store']);
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/help', [HelpController::class, 'index'])->name('help');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('institutions', InstitutionController::class);
    Route::resource('department', DepartmentController::class);
});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('project', ProjectController::class);
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('news', AdminNewsController::class);
    Route::resource('news-categories', NewsCategoryController::class)->names('news_categories');
});


Route::prefix('admin')->name('admin.sliders.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('sliders', [AdminSliderController::class, 'index'])->name('index');
    Route::get('sliders/create', [AdminSliderController::class, 'create'])->name('create');
    Route::post('sliders', [AdminSliderController::class, 'store'])->name('store');
    Route::get('sliders/{slider}/edit', [AdminSliderController::class, 'edit'])->name('edit');
    Route::put('sliders/{slider}', [AdminSliderController::class, 'update'])->name('update');
    Route::delete('sliders/{slider}', [AdminSliderController::class, 'destroy'])->name('destroy');
});


// routes/web.php
Route::prefix('admin/project')->name('admin.project.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/create', [ProjectController::class, 'create'])->name('create');
    Route::post('/', [ProjectController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ProjectController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProjectController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProjectController::class, 'destroy'])->name('destroy');

    Route::get('{project}/collaborators/{user}', [ProjectController::class, 'showCollaboratorDetail'])->name('collaborators.show');
    Route::get('/{id}/collaborators', [ProjectController::class, 'showCollaborators'])->name('collaborators.index');
    Route::get('/{id}/collaborators/pending', [ProjectController::class, 'pendingCollaborators'])->name('collaborators.pendingCollaborators');
    Route::post('/{projectId}/collaborators/{userId}/status', [ProjectController::class, 'updateCollaboratorStatus'])->name('collaborators.updateCollaboratorStatus');
    Route::delete('/{projectId}/collaborators/{userId}', [ProjectController::class, 'removeCollaborator'])->name('collaborators.removeCollaborator');
    Route::get('/{project}/pending-count', [ProjectController::class, 'pendingCount'])->name('admin.project.collaborators.pendingCount');

    Route::get('/pending', [ProjectController::class, 'pendingProjects'])->name('pending');
    Route::post('/{id}/approve', [ProjectController::class, 'approve'])->name('approve');
    Route::post('/{id}/reject', [ProjectController::class, 'reject'])->name('reject');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('galleries', GalleryController::class);
    Route::resource('gallery_files', GalleryFileController::class)->except(['show']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('projects/', [CollaboratorApplicationController::class, 'index'])->name('collaborator.projects');
    Route::get('projects/{id}/apply', [CollaboratorApplicationController::class, 'create'])->name('collaborator.apply');
    Route::post('projects/{id}/apply', [CollaboratorApplicationController::class, 'store'])->name('collaborator.store');
});

    
Route::middleware('auth')->group(function () {
    Route::get('/projects/{project}/daftar', [CollaboratorController::class, 'create'])->name('collaborators.create');
    Route::post('/projects/{project}/daftar', [CollaboratorController::class, 'store'])->name('collaborators.store');

});



















// Route untuk mengelola researchers
Route::middleware(['auth', 'role:researcher'])->group(function () {
    Route::get('/researcher/dashboard', [DashboardController::class, 'index'])->name('researchers.dashboard');


    Route::get('/researcher/profile', [ResearcherController::class, 'showProfile'])->name('researchers.profile');
    Route::get('/researcher/profile/edit', [ResearcherController::class, 'editProfile'])->name('researchers.editprofile');
    Route::put('/researcher/profile/update', [ResearcherController::class, 'updateProfile'])->name('researcher.profile.update');

    Route::post('/researcher/institution/store', [ResearcherController::class, 'storeInstitution'])->name('institution.store');
    Route::post('/researcher/department/store', [ResearcherController::class, 'store'])->name('department.store');

    
    // Rute untuk menampilkan daftar publikasi
    Route::get('/researcher/publications', [PublicationController::class, 'index'])->name('researchers.publications');
    
    // Rute untuk menyinkronkan publikasi
    Route::post('/researcher/publications/sync', [PublicationSyncController::class, 'sync'])->name('publications.sync');
    Route::post('/researchers/publications/sync', [PublicationController::class, 'syncFromForm'])->name('researchers.publication.sync');
    
    // Rute untuk menampilkan detail publikasi berdasarkan ID
    Route::get('/researcher/publications/{id}', [PublicationController::class, 'show'])->name('researchers.publications.show');

    
});

Route::prefix('researchers/projects')->middleware(['auth', 'role:researcher'])->name('researchers.projects.')->group(function () {
    // Routes untuk collaborators dulu supaya gak ketangkap {id}
    Route::get('collaborators', [ResearcherProjectCollaboratorController::class, 'index'])->name('collaborators.index');
    Route::get('collaborators/{project}/{user}', [ResearcherProjectCollaboratorController::class, 'show'])->name('collaborators.show');
    Route::post('collaborators/{project}/{user}/update-status', [ResearcherProjectCollaboratorController::class, 'updateCollaboratorStatus'])->name('collaborators.updateCollaboratorStatus');
    Route::delete('collaborators/{project}/{user}', [ResearcherProjectCollaboratorController::class, 'removeCollaborator'])->name('collaborators.removeCollaborator');

    // Route khusus submit publication harus dideklarasikan sebelum route {id}
    Route::get('{id}/submit', [ResearcherProjectController::class, 'submitPublication'])
        ->name('form')
        ->whereNumber('id');  // memastikan id hanya angka
    Route::post('{id}/submit', [ResearcherProjectController::class, 'storePublication'])
        ->name('submit')
        ->whereNumber('id');

    // Route standar untuk project
    Route::get('/', [ResearcherProjectController::class, 'index'])->name('index');
    Route::get('create', [ResearcherProjectController::class, 'create'])->name('create');
    Route::post('/', [ResearcherProjectController::class, 'store'])->name('store');
    Route::get('{id}', [ResearcherProjectController::class, 'show'])
        ->name('show')
        ->whereNumber('id');
    Route::get('{id}/edit', [ResearcherProjectController::class, 'edit'])
        ->name('edit')
        ->whereNumber('id');
    Route::put('{id}', [ResearcherProjectController::class, 'update'])
        ->name('update')
        ->whereNumber('id');
    Route::delete('{id}', [ResearcherProjectController::class, 'destroy'])
        ->name('destroy')
        ->whereNumber('id');
});


// Group route khusus untuk peneliti yang sudah login
Route::middleware(['auth', 'role:researcher'])->prefix('researcher')->name('researchers.')->group(function () {

    // Halaman daftar proyek yang bisa dijoin
    Route::get('/join-projects', [JoinProjectController::class, 'index'])->name('projects.join.index');

    // Aksi untuk join proyek
    Route::post('/join-projects/{project}', [JoinProjectController::class, 'join'])->name('projects.join.request');
    // Aksi untuk join proyek tertentu
    Route::post('/projects/{project}/join', [JoinProjectController::class, 'join'])->name('projects.join');
});
















// Buyer routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart', [CartController::class, 'viewCart'])->name('Buyer.cart');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('Buyer.checkout');

    
    Route::get('/dataset', [DatasetController::class, 'index'])->name('buyer.dataset');
    Route::get('/dataset/{id}', [DatasetController::class, 'show'])->name('dataset.show');
    Route::post('/dataset', [DatasetController::class, 'store'])->name('dataset.store');
    Route::put('/dataset/{id}', [DatasetController::class, 'update'])->name('dataset.update');
    Route::delete('/dataset/{id}', [DatasetController::class, 'destroy'])->name('dataset.destroy');
});



Route::get('/tes-config', function () {
    return config('services.scopus.key');
});

