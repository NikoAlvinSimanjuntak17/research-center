<!-- Main navbar -->
<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="navbar-brand flex-1 flex-lg-0">
            <a href="{{route('dashboard')}}" class="d-inline-flex align-items-center" target="_blank">
                <img src="{{ asset('frontend/eduka/assets/img/logo/logo_stt_hkbp_with_name.png') }}" alt="">
                <!-- <img src="{{ URL::asset('backend/assets/images/logo_text_light.svg') }}" class="d-none d-sm-inline-block h-16px ms-3" alt=""> -->
            </a>  
        </div>

        <ul class="nav flex-row">
            <li class="nav-item d-lg-none">
                <a href="#navbar_search" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="collapse">
                    <i class="ph-magnifying-glass"></i>
                </a>
            </li>
        </ul>
        <li class="nav-item dropdown">



        <ul class="nav flex-row justify-content-end order-1 order-lg-2">
            @php
                $notifications = Auth::user()->notifications()->take(10)->get();
            @endphp
            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link rounded-pill p-1 position-relative" data-bs-toggle="dropdown">
                    <i class="ph-bell fs-5"></i>
                    @if (Auth::user()->unreadNotifications->count() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width: 340px; max-height: 420px; overflow-y: auto;">
                    <li class="dropdown-header fw-bold px-3 pt-2">Notifikasi Terbaru</li>

                    @forelse (Auth::user()->notifications->take(10) as $notif)
                        @php
                            $data = $notif->data;
                            $icon = match(true) {
                                str_contains(strtolower($data['message']), 'review') => 'ph-star',
                                str_contains(strtolower($data['message']), 'unduh') || str_contains(strtolower($data['message']), 'download') => 'ph-download',
                                str_contains(strtolower($data['message']), 'token') => 'ph-check-circle',
                                str_contains(strtolower($data['message']), 'bayar') || str_contains(strtolower($data['message']), 'paid') => 'ph-credit-card',
                                default => 'ph-info',
                            };
                        @endphp
                        <li>
                            <a href="{{ $data['url'] ?? '#' }}" class="dropdown-item d-flex align-items-start gap-3 {{ $notif->read_at ? '' : 'bg-light' }}">
                                <i class="ph {{ $icon }} fs-4 text-primary"></i>
                                <div class="flex-fill">
                                    <div class="fw-semibold">{{ $data['title'] ?? 'Notifikasi' }}</div>
                                    <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li>
                            <div class="dropdown-item text-muted">Tidak ada notifikasi.</div>
                        </li>
                    @endforelse

                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form method="POST" action="{{ route('admin.notifications.markAsRead') }}">
                            @csrf
                            <button class="dropdown-item text-center text-primary small">Tandai semua telah dibaca</button>
                        </form>
                    </li>
                </ul>
            </li>

<li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                    <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
                        <div class="status-indicator-container">
                            <img src="{{ URL::asset('images/user_icon.png') }}" class="w-32px h-32px rounded-pill"
                                alt="">
                            <span class="status-indicator bg-success"></span>
                        </div>
                        @php
                            $user = Auth::user();
                        @endphp
                        <span class="d-none d-lg-inline-block mx-lg-2">{{ $user->name }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        {{-- Arahkan profil berdasarkan role --}}
                        @if($user->hasRole('admin'))
                            <a href="{{ route('admin.profile.show') }}" class="dropdown-item">
                                <i class="ph-user-circle me-2"></i> My profile
                            </a>
                        @elseif($user->hasRole('researcher'))
                            <a href="{{ route('researcher.profile.show') }}" class="dropdown-item">
                                <i class="ph-user-circle me-2"></i> My profile
                            </a>
                        @else
                            <a href="#" class="dropdown-item disabled">
                                <i class="ph-user-circle me-2"></i> My profile
                            </a>
                        @endif

                        <div class="dropdown-divider"></div>

                        <form method="POST" action="{{ route('post-logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="ph-sign-out me-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </li>
        </ul>
    </div>
</div>

