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
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <i class="ph-house"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.profiles.index') }}" class="nav-link {{ Request::is('admin/organization*') ? 'active' : '' }}">
        <i class="ph-tree-structure"></i>
        <span>Profiles</span>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.sliders.index') }}" class="nav-link {{ Request::is('admin/sliders*') ? 'active' : '' }}">
        <i class="ph-slideshow"></i>
        <span>Sliders</span>
    </a>
</li>

<li class="nav-item nav-item-submenu {{ Request::is('admin/researchers*', 'admin/publications*') ? 'nav-item-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('admin/researchers*', 'admin/publications*') ? 'active' : '' }}">
        <i class="ph-book-open"></i>
        <span>Researcher</span>
    </a>
    <ul class="nav-group-sub collapse {{ Request::is('admin/researchers*', 'admin/publications*') ? 'show' : '' }}">
        <li class="nav-item">
            <a href="{{ route('admin.researchers.index') }}" class="nav-link {{ Request::is('admin/researchers*') ? 'active' : '' }}">
                Daftar researcher
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.publications.index') }}" class="nav-link {{ Request::is('admin/publications*') ? 'active' : '' }}">
                Publication
            </a>
        </li>
    </ul>
</li>

<li class="nav-item nav-item-submenu {{ Request::is('admin/institutions*', 'admin/department*') ? 'nav-item-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('admin/institutions*', 'admin/department*') ? 'active' : '' }}">
        <i class="ph-handshake"></i>
        <span>Affiliation</span>
    </a>
    <ul class="nav-group-sub collapse {{ Request::is('admin/institutions*', 'admin/department*') ? 'show' : '' }}">
        <li class="nav-item">
            <a href="{{ route('admin.institutions.index') }}" class="nav-link {{ Request::is('admin/institutions*') ? 'active' : '' }}">
                Institution
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.department.index') }}" class="nav-link {{ Request::is('admin/department*') ? 'active' : '' }}">
                Department
            </a>
        </li>
    </ul>
</li>

<li class="nav-item nav-item-submenu {{ 
    Request::is('admin/project') 
    || (Request::is('admin/project/*') && !Request::is('admin/project/*/collaborators*')) 
    || (isset($project) && Request::is('admin/project/' . $project->id . '/collaborators*')) 
    ? 'nav-item-open' : '' 
}}">
    <a href="#" class="nav-link {{ 
        Request::is('admin/project') 
        || (Request::is('admin/project/*') && !Request::is('admin/project/*/collaborators*')) 
        || (isset($project) && Request::is('admin/project/' . $project->id . '/collaborators*')) 
        ? 'active' : '' 
    }}">
        <i class="ph-users-three"></i>
        <span>Proyek Kolaborasi</span>
        @if(!empty($totalPendingCollaborators) && $totalPendingCollaborators > 0)
            <span class="badge bg-warning text-dark ms-2">{{ $totalPendingCollaborators }}</span>
        @endif
    </a>

    <ul class="nav-group-sub collapse {{ 
        Request::is('admin/project') 
        || (Request::is('admin/project/*') && !Request::is('admin/project/*/collaborators*')) 
        || (isset($project) && Request::is('admin/project/' . $project->id . '/collaborators*')) 
        ? 'show' : '' 
    }}">
        <li class="nav-item">
            <a href="{{ route('admin.project.index') }}" class="nav-link {{ 
                Request::is('admin/project') 
                || (Request::is('admin/project/*') && !Request::is('admin/project/*/collaborators*')) 
                ? 'active' : '' 
            }}">
                Proyek
            </a>
        </li>
        <li class="nav-item">
            @isset($project)
            <a href="{{ route('admin.project.collaborators.index', ['id' => $project->id]) }}" 
                class="nav-link {{ 
                    Request::is('admin/project/' . $project->id . '/collaborators*') 
                    ? 'active' : '' 
                }}">
                Kolaborator
                @php
                    $pendingCount = $project->collaborators->where('status', 'pending')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="badge bg-warning text-dark ms-2">{{ $pendingCount }}</span>
                @endif
            </a>
            @endisset
        </li>
    </ul>
</li>



<li class="nav-item nav-item-submenu {{ Request::is('admin/news*', 'admin/news-categories*') ? 'nav-item-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('admin/news*', 'admin/news-categories*') ? 'active' : '' }}">
        <i class="ph-newspaper"></i>
        <span>Berita</span>
    </a>
    <ul class="nav-group-sub collapse {{ Request::is('admin/news*', 'admin/news-categories*') ? 'show' : '' }}">
        <li class="nav-item">
            <a href="{{ route('admin.news_categories.index') }}" class="nav-link {{ Request::is('admin/news-categories*') ? 'active' : '' }}">
                Kategori Berita
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.news.index') }}" class="nav-link {{ Request::is('admin/news*') && !Request::is('admin/news-categories*') ? 'active' : '' }}">
                Daftar Berita
            </a>
        </li>
    </ul>
</li>


<li class="nav-item nav-item-submenu {{ Request::is('admin/galleries*', 'admin/gallery_files*') ? 'nav-item-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('admin/galleries*', 'admin/gallery_files*') ? 'active' : '' }}">
        <i class="ph-image-square"></i>
        <span>Gallery</span>
    </a>
    <ul class="nav-group-sub collapse {{ Request::is('admin/galleries*', 'admin/gallery_files*') ? 'show' : '' }}">
        <li class="nav-item">
            <a href="{{ route('admin.galleries.index') }}" class="nav-link {{ Request::is('admin/galleries*') ? 'active' : '' }}">
                Galleries
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.gallery_files.index') }}" class="nav-link {{ Request::is('admin/gallery_files*') ? 'active' : '' }}">
                Gallery Files
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ Request::is('admin/contacts*') ? 'active' : '' }}">
        <i class="ph-phone"></i>
        <span>Contacts</span>
    </a>
</li>



</ul>

    </div>
    <!-- /main navigation -->

  </div>
  <!-- /sidebar content -->
  
</div>
<!-- /main sidebar -->