<!-- Page content -->
<div class="page-content">

<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

  <!-- Sidebar content -->
  <div class="sidebar-content">

    <!-- Sidebar header -->
    <div class="sidebar-section">
      <div class="sidebar-section-body d-flex justify-content-center">
        <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigation</h5>

        <div>
          <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
            <i class="ph-arrows-left-right"></i>
          </button>

          <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
            <i class="ph-x"></i>
          </button>
        </div>
      </div>
    </div>
    <!-- /sidebar header -->


    <!-- Main navigation -->
    <div class="sidebar-section">
    <ul class="nav nav-sidebar" data-nav-type="accordion">

<!-- Main -->
<li class="nav-item-header pt-0">
    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Main</div>
    <i class="ph-dots-three sidebar-resize-show"></i>
</li>

<li class="nav-item">
    <a href="{{ route('researchers.dashboard')}}" class="nav-link {{ Request::is('researcher/dashboard') ? 'active' : '' }}">
        <i class="ph-house"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="nav-item {{ Request::is('researcher/publication*') ? 'nav-item-open' : '' }}">
    <a href="{{ route('researchers.publications') }}" class="nav-link {{ Request::is('researcher/publication*') ? 'active' : '' }}">
        <i class="ph-image"></i>
        <span>Publication</span>
    </a>
</li>

<li class="nav-item nav-item-submenu {{ Request::is('researchers/projects*') || Request::is('researcher/join-projects*') ? 'nav-item-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('researchers/projects*') || Request::is('researcher/join-projects*') ? 'active' : '' }}">
        <i class="ph-users-three"></i>
        <span>Proyek Kolaborasi</span>
    </a>
    <ul class="nav-group-sub collapse {{ Request::is('researchers/projects*') || Request::is('researcher/join-projects*') ? 'show' : '' }}" data-submenu-title="Proyek Kolaborasi">
        <li class="nav-item">
            <a href="{{ route('researchers.projects.index') }}" class="nav-link {{ Request::is('researchers/projects') || Request::is('researchers/projects/') ? 'active' : '' }}">
                Proyek
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('researchers.projects.collaborators.index') }}" class="nav-link {{ Request::is('researchers/projects/collaborators*') ? 'active' : '' }}">
                Kolaborator
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('researchers.projects.join.index') }}" class="nav-link {{ Request::is('researcher/join-projects*') ? 'active' : '' }}">
                Gabung Proyek
            </a>
        </li>
    </ul>
</li>


</ul>

    </div>
    <!-- /main navigation -->

  </div>
  <!-- /sidebar content -->
  
</div>
<!-- /main sidebar -->