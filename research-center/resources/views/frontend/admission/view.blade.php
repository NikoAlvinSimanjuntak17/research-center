@extends('layout.frontend.main', ['activePage' => 'index', 'titlePage' => __('Home')])
@section('title','Home')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <!-- facility single -->
        <div class="facility-single-area py-120">
            <div class="container">
                <div class="facility-single-wrapper">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4">
                            <div class="facility-sidebar">
                                <div class="widget facility-download">
                                    <h4 class="widget-title">Download</h4>
                                    <a href="https://drive.google.com/file/d/1aM8_yqfvvp_7mfayXavh5m52xcAYcFFY/view?usp=sharing"><i class="far fa-file-pdf"></i> Download File {{$admission->title}}</a>
                                    {{-- <a href="#"><i class="far fa-file-alt"></i> Download Application</a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8">
                            <div class="facility-details">
                                <div class="facility-details-img mb-30">
                                    <img src="{{ asset('frontend/eduka/assets/img/slider/slider5.jpg') }}" alt="thumb">
                                </div>
                                <div class="facility-details">
                                    <h4 class="title">{{$admission->title}}</h4>
                                    <div class="facility-details-content mb-30">
                                        <p>{!! $admission->description !!}</p>
                                        <p>File : <a href="{{ asset('storage/'.$admission->file) }}" target="_blank">{{ $admission->file }}</a></p>
                                        <p>Created At : {{ $admission->created_at }}</p>
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- facility single end-->
        </div>
    </div>
@endsection