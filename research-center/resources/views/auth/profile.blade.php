@include('layouts.header')

<section class="page-header">
    <!-- /.page-header__bg -->
    <div class="container">
        <div class="page-header__bg" style="background-image: url{{ asset('images/backgrounds/slider-1-1.jpg') }}"></div>
        <h2 class="page-header__title">Profile</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="#">Home</a></li>
            <li><span>Profile</span></li>
        </ul><!-- /.thm-breadcrumb list-unstyled -->
    </div><!-- /.container -->
</section><!-- /.page-header -->
<section class="about-fore">
    <div class="container">
        <div class="card shadow-lg p-4">
            <h2 class="text-center mb-4">My Profile</h2>
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="https://via.placeholder.com/150" class="rounded-circle img-thumbnail" alt="Profile Picture">
                </div>
                <div class="col-md-8">
                    <table class="table">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Role:</th>
                            <td>{{ $user->roles()->first()->name ?? 'N/A' }}</td>
                        </tr>
                    </table>
                    <a href="{{ route('logout') }}" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                    class="btn btn-danger">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
            <div class ="row">
                <div class="col-md-12 mt-4">
                    <ul class="nav nav-tabs mt-4" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="ongoing-projects-tab" data-bs-toggle="tab" data-bs-target="#ongoing-projects" type="button" role="tab">Project Aktif</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="completed-projects-tab" data-bs-toggle="tab" data-bs-target="#completed-projects" type="button" role="tab">Project Selesai</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="publications-tab" data-bs-toggle="tab" data-bs-target="#publications" type="button" role="tab">Publikasi</button>
                        </li>
                    </ul>
                    <div class="tab-content p-3 border border-top-0" id="profileTabsContent">
                        <!-- Project Aktif -->
                        <div class="tab-pane fade show active" id="ongoing-projects" role="tabpanel">
                            @if($ongoingProjects->isEmpty())
                            <p>Tidak ada project yang sedang diikuti.</p>
                            @else
                            <ul class="list-group">
                                @foreach($ongoingProjects as $project)
                                <li class="list-group-item">
                                    <strong>{{ $project->title }}</strong><br>
                                    {!! $project->description !!}
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                        
                        <!-- Project Selesai -->
                        <div class="tab-pane fade" id="completed-projects" role="tabpanel">
                            @if($completedProjects->isEmpty())
                            <p>Belum ada project yang selesai.</p>
                            @else
                            <ul class="list-group">
                                @foreach($completedProjects as $project)
                                <li class="list-group-item">
                                    <strong>{{ $project->title }}</strong><br>
                                    {!! $project->description !!}
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                        
                        <!-- Publikasi -->
                        <div class="tab-pane fade" id="publications" role="tabpanel">
                            @if($publications->isEmpty())
                            <p>Belum ada publikasi.</p>
                            @else
                            <ul class="list-group">
                                @foreach($publications as $pub)
                                <li class="list-group-item">
                                    <strong>{{ $pub->title }}</strong> <br>
                                    <small>{{ $pub->year }} | {{ $pub->category }}</small>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</section>
@include('layouts.footer')