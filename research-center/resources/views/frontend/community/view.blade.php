@extends('layout.frontend.main', ['activePage' => 'frontend-community.view', 'titlePage' => __('View Komunitas')])
@section('title','View Komunitas')

@section('content')
    <!-- blog single area -->
    <div class="blog-single-area pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <aside class="sidebar">
                       
                        <!-- category -->
                        <div class="widget category">
                            <h5 class="widget-title">Komunitas</h5>
                            <div class="category-list">
                                @foreach ($model_all as $value)
                                    <a href="{{route('frontend-community.view',['id'=>$value->id])}}"><i class="far fa-arrow-right"></i>{{$value->title}}</span></a>
                                @endforeach
                                
                                
                            </div>
                        </div>
                      
                </div>

                <div class="col-lg-8">
                    <div class="blog-single-wrapper">
                        <div class="blog-single-content">
                            <div class="blog-thumb-img">
                                <img src="{{ asset('images/'.$model->image) }}"  alt="thumb">
                            </div>
                            <div class="blog-info">
                                <div class="blog-meta">
                                    <div class="blog-meta-left">
                                        <ul>
                                            <li><i class="far fa-clock"></i><a href="#">{{$model->updated_at}}</a></li>
                                            <li><i class="far fa-comments"></i></li>
                                            <li><i class="far fa-thumbs-up"></i></li>
                                        </ul>
                                    </div>
                                    <div class="blog-meta-right">
                                        <a href="#" class="share-link"><i class="far fa-share-alt"></i></a>
                                    </div>
                                </div>
                                <div class="blog-details">
                                    <h3 class="blog-details-title mb-20">{{$model->title}}</h3>
                                    <p class="mb-10">
                                        {!! $model->description !!}
                                    </p>
                                    
                                    <hr>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- blog single area end -->
@endsection