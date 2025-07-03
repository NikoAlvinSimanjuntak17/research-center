<?php
use Carbon\Carbon;
?>
@extends('layout.frontend.main', ['activePage' => 'index', 'titlePage' => __('View Dosen')])
@section('title','View Dosen')

@section('content')
    <!-- blog area -->
    <div class="blog-area py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="site-heading text-center">
                        <h3 class="site-title">DATA DOSEN <span class="text-primary">STT HKBP Pematangsiantar</span></span></h3>
                        
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- @foreach ($model_all as $value)
                    <div class="col-md-6 col-lg-4">
                        <div class="team-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="team-img">
                                <img src="{{ asset('images/'.$value->image) }}" alt="thumb">
                            </div>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-whatsapp"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                            </div>
                            <div class="team-content">
                                <div class="team-bio">
                                    <h5><a href="#">{{$value->full_name}}</a></h5>
                                    <span class="text-success">{{$value->last_education}}</span><br>
                                    <span class="text-primary">{{$value->expertise}}</span>
                                </div>
                            </div>
                            <span class="team-social-btn"><i class="far fa-share-nodes"></i></span>
                        </div>
                    </div>
                @endforeach --}}

                @foreach ($model_all as $value)
                <div class="col-md-6 col-lg-4">
                    <div class="event-item">
                        <div class="team-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="team-img">
                                <img src="{{ asset('images/'.$value->image) }}" alt="thumb">
                            </div>
                            {{-- <div class="team-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-whatsapp"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                            </div> --}}
                            <div class="team-content">
                                <div class="team-bio">
                                    <h5><a href="#">{{$value->full_name}}</a></h5>
                                    <span class="text-success">{{$value->last_education}}</span><br>
                                    <span class="text-primary">{{$value->expertise}}</span>
                                </div>
                            </div>
                            <span class="team-social-btn"><i class="far fa-share-nodes"></i></span>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- blog area end -->
@endsection