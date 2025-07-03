@extends('layout.frontend.main', ['activePage' => 'index', 'titlePage' => __('View Berita')])
@section('title','View Berita')

@section('content')
    <!-- blog single area -->
    <div class="blog-single-area pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="blog-single-wrapper">
                        <div class="blog-single-content">
                           
                            <div class="blog-info">
                                
                                <div class="blog-details">
                                    <h3 class="blog-details-title mb-20">{{$model->title}}</h3>
                                    <p class="mb-10">
                                        {!! $model->description !!}
                                    </p>
                                    
                                    <hr>
                                    
                                </div>
                                <div class="blog-meta">
                                    <div class="blog-meta-left">
                                        <ul>
                                            <li><i class="far fa-clock"></i><a href="#">{{ date('d M y',strtotime($model->updated_at)) }}</a></li>
                                            <li><i class="far fa-user"></i>{{$user->name}}</li>
                                            {{-- <li><i class="far fa-thumbs-up"></i></li> --}}
                                        </ul>
                                    </div>
                                    <div class="blog-meta-right">
                                        <a href="#" class="share-link"><i class="far fa-share-alt"></i></a>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
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
                            <h5 class="widget-title">Pengumuman Terupdate</h5>
                            @foreach ($model_all as $value)
                            <div class="recent-post-single">
                               
                                <div class="recent-post-bio">
                                    <h6><a href="{{route('frontend-announcement.view',['id'=>$value->id])}}">{{ $value->title }}</a></h6>
                                    <span><i class="far fa-clock"></i>{{ date('d M y',strtotime($value->updated_at)) }}</span>
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
                        {{-- <div class="widget sidebar-tag">
                            <h5 class="widget-title">Kategori Berita</h5>
                            <div class="tag-list">
                                @foreach ($news_category as $value)
                                    <a href="#">{{$value->name}}</a>
                                @endforeach
                            </div>
                        </div> --}}
                    </aside>
                </div>
            </div>
        </div>
    </div>
    <!-- blog single area end -->
@endsection