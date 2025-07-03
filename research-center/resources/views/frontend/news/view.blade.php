@extends('layout.frontend.main', ['activePage' => 'index', 'titlePage' => __('View Berita')])
@section('title','View Berita')

@section('content')
    <section id="subheader" class="relative jarallax text-light">
        @php
        use Illuminate\Support\Facades\DB;
        $slider = DB::table('sliders')
        ->where('active', 1)
        ->orderBy('updated_at', 'desc')
        ->first(); // ganti get() dengan first()

        @endphp
        <img src="{{ asset(asset('storage/sliders/' . $slider->image)) }}" class="jarallax-img" alt="">
        <div class="container relative z-index-1000">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="crumb">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li class="active">Berita</li>
                    </ul>
                    <h1 class="text-uppercase">Berita</h1>
                    <p class="col-lg-10 lead">Temukan berbagai berita penelitian kami yang inovasi dan terpecaya.</p>
                </div>
            </div>
        </div>
        <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
        <div class="de-gradient-edge-top dark"></div>
        <div class="de-overlay"></div>
    </section>
    <!-- blog single area -->
    <div class="blog-single-area pt-120 pb-120" >
        <div class="container">
            <div class="row" >
                <div class="col-lg-8" style="margin-top: 10em">
                    <div class="blog-single-wrapper" >
                        <div class="blog-single-content">
                            <div class="blog-thumb-img" style="height: 500px; overflow: hidden; border-radius: 10px;">
                                <img 
                                    src="{{ asset('storage/news/'.$news->image) }}" 
                                    alt="thumb" 
                                    style="width: 100%; height: 100%; object-fit: cover;"
                                >
                            </div>

                            <div class="blog-info">
                                <div class="blog-meta">
                                    <div class="blog-meta-left">
                                        <ul>
                                            <li><i class="far fa-clock"></i><a href="#"> {{$news->updated_at}}</a></li>
                                        </ul>
                                    </div>
                                    <div class="blog-meta-right">
                                        <a href="#" class="share-link"><i class="far fa-share-alt"></i></a>
                                    </div>
                                </div>
                                <div class="blog-details">
                                    <h3 class="blog-details-title mb-20">{{$news->title}}</h3>
                                    <p class="mb-10">
                                        {!! $news->description !!}
                                    </p>
                                    
                                    <hr>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="margin-top: 10em">
                    <aside class="sidebar">
                        <!-- search-->
                        <div class="widget search">
                            <h5 class="widget-title">Search</h5>
                            <form class="search-form">
                                <input type="text" class="form-control" placeholder="Search Here...">
                                <button type="submit"><i class="far fa-search"></i></button>
                            </form>
                        </div>
                        {{-- <!-- category -->
                        <div class="widget category">
                            <h5 class="widget-title">Category</h5>
                            <div class="category-list">
                                <a href="#"><i class="far fa-arrow-right"></i>Online Courses<span>(10)</span></a>
                                <a href="#"><i class="far fa-arrow-right"></i>Basic Knowledge<span>(15)</span></a>
                                <a href="#"><i class="far fa-arrow-right"></i>Improve Your Skills<span>(20)</span></a>
                                <a href="#"><i class="far fa-arrow-right"></i>Proffesionals Course<span>(30)</span></a>
                                <a href="#"><i class="far fa-arrow-right"></i>Complete Course<span>(25)</span></a>
                            </div>
                        </div> --}}
                        <!-- recent post -->
                        <div class="widget recent-post">
                            <h5 class="widget-title">Berita Terupdate</h5>
                            @foreach ($news_all as $value)
                            <div class="recent-post-single">
                                <div class="recent-post-img" style="width: 100px; height: 80px; overflow: hidden; border-radius: 6px;">
                                    <img 
                                        src="{{ asset('storage/news/'.$value->image) }}" 
                                        alt="thumb" 
                                        style="width: 100%; height: 100%; object-fit: cover;"
                                    >
                                </div>

                                <div class="recent-post-bio mt-2">
                                    <h6><a href="{{route('frontend-news.view',['id'=>$value->id])}}">{{ $value->title }}</a></h6>
                                    <span><i class="far fa-clock"></i> {{ $value->updated_at }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- social share -->
                        <div class="widget social-share">
                            <h5 class="widget-title">Ikuti Kami</h5>
                            <div class="social-share-link">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-dribbble"></i></a>
                                <a href="#"><i class="fab fa-whatsapp"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                        <!-- Recent Post -->
                        <div class="widget sidebar-tag">
                            <h5 class="widget-title">Kategori Berita</h5>
                            <div class="tag-list">
                                @foreach ($news_category as $value)
                                    <a href="#">{{$value->name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    <!-- blog single area end -->
@endsection