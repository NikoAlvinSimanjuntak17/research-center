<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Admin TSTH2</h5>

                <div>
                    <button type="button"
                        class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button"
                        class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- /sidebar header -->

        <?php
$user = Auth::user();
$role_user = DB::table('role_user')->where('user_id', $user->id)->first();
                
            
        ?>
        <!-- Main navigation -->
        <div class="sidebar-section" style="margin-bottom: 20px;">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                @if ($role_user->role_id == 1)
                    <!-- Main -->
                    <li class="nav-item-header pt-0">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Main</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('dashboard')}}"
                            class="nav-link {{ $activePage == 'dashboard.index' ? ' active' : '' }}">
                            <i class="ph-house"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('profile.index')}}"
                            class="nav-link {{ $activePage == 'profile.index' ? ' active' : '' }}">
                            <i class="ph-circles-four"></i>
                            <span>Profil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('slider.index')}}" class="nav-link {{ $activePage == '#' ? ' active' : '' }}">
                            <i class="ph-sidebar"></i>
                            <span>Slider</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('news.index')}}"
                            class="nav-link {{ $activePage == 'news.index' ? ' active' : '' }}">
                            <i class="ph-newspaper"></i>
                            <span>Berita & Informasi</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.partnership.index') }}"
                            class="nav-link {{ Request::is('admin/partnership*') ? 'active' : '' }}">
                            <i class="ph-handshake"></i>Kerja Sama
                        </a>
                    </li>

                    <li
                        class="nav-item nav-item-submenu {{ Request::is('admin/galleries*', 'admin/gallery_files*') ? 'nav-item-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('admin/galleries*', 'admin/gallery_files*') ? 'active' : '' }}">
                            <i class="ph-image-square"></i>
                            <span>Gallery</span>
                        </a>
                        <ul
                            class="nav-group-sub collapse {{ Request::is('admin/galleries*', 'admin/gallery_files*') ? 'show' : '' }}">
                            <li class="nav-item">
                                <a href="{{ route('admin.galleries.index') }}"
                                    class="nav-link {{ Request::is('admin/galleries*') ? 'active' : '' }}">
                                    Galleries
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.gallery_files.index') }}"
                                    class="nav-link {{ Request::is('admin/gallery_files*') ? 'active' : '' }}">
                                    Gallery Files
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="nav-item nav-item-submenu {{ Request::is('admin/institutions*', 'admin/department*') ? 'nav-item-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('admin/institutions*', 'admin/department*') ? 'active' : '' }}">
                            <i class="ph-handshake"></i>
                            <span>Affiliation</span>
                        </a>
                        <ul
                            class="nav-group-sub collapse {{ Request::is('admin/institutions*', 'admin/department*') ? 'show' : '' }}">
                            <li class="nav-item">
                                <a href="{{ route('admin.institutions.index') }}"
                                    class="nav-link {{ Request::is('admin/institutions*') ? 'active' : '' }}">
                                    Institution
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.department.index') }}"
                                    class="nav-link {{ Request::is('admin/department*') ? 'active' : '' }}">
                                    Department
                                </a>
                            </li>
                        </ul>
                    </li>
                                        <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}"
                            href="#">
                            <i class="ph-newspaper"></i>
                            <span>Semua Pesanan</span>
                        </a>
                    </li>

                    <li class="nav-item-header pt-0 my-2">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Penelitian</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('researcher.index') }}"
                            class="nav-link {{ Request::is('admin/researchers*') ? 'active' : '' }}">
                            <i class="ph-user"></i>Researcher
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.research-facility.index') }}"
                            class="nav-link {{ Request::is('admin/research-facility*') ? 'active' : '' }}">
                            <i class="ph-buildings"></i>Fasilitas Penelitian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.publications.index') }}"
                            class="nav-link {{ Request::is('admin/publication*') ? 'active' : '' }}">
                            <i class="ph-notebook"></i>Publikasi Penelitian
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="{{ route('admin.commodity.index') }}"
                            class="nav-link {{ Request::is('admin/commodity*') ? 'active' : '' }}">
                            <i class="ph-archive"></i>Komoditas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ $activePage == '#' ? ' active' : '' }}">
                            <i class="ph-flask"></i>
                            <span>Dataset</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ $activePage == '#' ? ' active' : '' }}">
                            <i class="ph-tag"></i>
                            <span>Kupon</span>
                        </a>
           
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ $activePage == '#' ? ' active' : '' }}">
                            <i class="ph-calendar-blank"></i>
                            <span>Events</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ $activePage == '#' ? ' active' : '' }}">
                            <i class="ph-newspaper"></i>
                            <span>Sertifikat</span>
                        </a>
                    </li>

                    <li
                        class="nav-item nav-item-submenu {{ Request::is('admin/projects*', 'admin/collaborators*') ? 'nav-item-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('admin/projects*', 'admin/collaborators*') ? 'active' : '' }}">
                            <i class="ph-handshake"></i>
                            <span>Proyek Kolaborasi</span>
                        </a>
                        <ul
                            class="nav-group-sub collapse {{ Request::is('admin/projects*', 'admin/collaborators*') ? 'show' : '' }}">
                            <li class="nav-item">
                                <a href="#"
                                    class="nav-link {{ Request::is('admin/projects*') && !Request::is('admin/projects/collaborators*') ? 'active' : '' }}">
                                    Proyek
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#"
                                    class="nav-link {{ Request::is('admin/collaborators*') ? 'active' : '' }}">
                                    Kolaborator
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('contact.index') }}"
                            class="nav-link {{ Request::is('admin/contact*') ? 'active' : '' }}">
                            <i class="ph-phone"></i>Contact
                        </a>
                    </li>
                    

                @endif
                <!-- <li class="nav-item">
                            <a href="{{route('lecturer.index')}}"
                                class="nav-link {{ $activePage == 'lecturer.index' ? ' active' : '' }}">
                                <i class="ph-users-four"></i>
                                <span>Dosen</span>
                            </a>
                        </li> -->

                <!-- <li class="nav-item">
                            <a href="{{route('admission.index')}}"
                                class="nav-link {{ $activePage == 'admission.index' ? ' active' : '' }}">
                                <i class="ph-laptop"></i>
                                <span>Admisi</span>
                            </a>
                        </li> -->

                <!-- <li class="nav-item">
                            <a href="#" class="nav-link {{ $activePage == '#' ? ' active' : '' }}">
                                <i class="ph-info"></i>
                                <span>Pengumuman</span>
                            </a>
                        </li> -->

                <!-- <li class="nav-item">
                            <a href="{{route('study-program.index')}}"
                                class="nav-link {{ $activePage == '#' ? ' active' : '' }}">
                                <i class="ph-list"></i>
                                <span>Pendidikan</span>
                            </a>
                        </li> -->

                <!-- <li class="nav-item">
                            <a href="{{route('study-centre.index')}}"
                                class="nav-link {{ $activePage == '#' ? ' active' : '' }}">
                                <i class="ph-file"></i>
                                <span>Pusat Studi</span>
                            </a>
                        </li> -->

                <!-- <li class="nav-item">
                            <a href="#" class="nav-link {{ $activePage == '#' ? ' active' : '' }}">
                                <i class="ph-cards"></i>
                                <span>LPPM</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link {{ $activePage == '#' ? ' active' : '' }}">
                                <i class="ph-cards"></i>
                                <span>LPMI</span>
                            </a>
                        </li> -->
                <!-- <li class="nav-item">
                            <a href="{{route('community.index')}}" class="nav-link {{ $activePage == '#' ? ' active' : '' }}">
                                <i class="ph-users-three"></i>
                                <span>Komunitas</span>
                            </a>
                        </li> -->

                @if ($role_user->role_id == 2)
                    <li class="nav-item">
                        <a href="{{route('researcher.dashboard')}}"
                            class="nav-link {{ $activePage == 'dashboard.index' ? ' active' : '' }}">
                            <i class="ph-house"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('researcher.publications') }}"
                            class="nav-link {{ Request::is('researcher/publications*') ? 'active' : '' }}">
                            <i class="ph-books"></i>
                            Publikasi Penelitian
                        </a>
                    </li>
                    <li
                        class="nav-item nav-item-submenu {{ Request::is('researcher/projects*', 'researcher/projects/collaborators*', 'researcher/join-projects*') ? 'nav-item-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('researcher/projects*', 'researcher/projects/collaborators*', 'researcher/join-projects*') ? 'active' : '' }}">
                            <i class="ph-handshake"></i>
                            <span>Proyek Kolaborasi</span>
                        </a>
                        <ul
                            class="nav-group-sub collapse {{ Request::is('researcher/projects*', 'researcher/projects/collaborators*', 'researcher/join-projects*') ? 'show' : '' }}">
                            <li class="nav-item">
                                <a href="#"
                                    class="nav-link {{ Request::is('researcher/projects') || (Request::is('researcher/projects/*') && !Request::is('researcher/projects/collaborators*')) ? 'active' : '' }}">
                                    Daftar Proyek
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#"
                                    class="nav-link {{ Request::is('researcher/projects/collaborators*') ? 'active' : '' }}">
                                    Daftar Kolaborator
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#"
                                    class="nav-link {{ Request::is('researcher/join-projects*') ? 'active' : '' }}">
                                    Gabung Proyek
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ $activePage == '#' ? ' active' : '' }}">
                            <i class="ph-flask"></i>
                            <span>Dataset</span>
                        </a>
                    </li>

                @endif

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->