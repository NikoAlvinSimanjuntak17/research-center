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
                                    <a href="https://drive.google.com/file/d/1aM8_yqfvvp_7mfayXavh5m52xcAYcFFY/view?usp=sharing"><i class="far fa-file-pdf"></i> Download Brosur Penerimaan Mahasiswa Baru</a>
                                    {{-- <a href="#"><i class="far fa-file-alt"></i> Download Application</a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8">
                            <div class="facility-details">
                                <div class="facility-details-img mb-30">
                                    <img src="assets/img/facility/single.jpg" alt="thumb">
                                </div>
                                <div class="facility-details">
                                    <h3 class="mb-20">Tanggal Pendaftaran</h3>
                                    <table class="table">
                                        <tr>
                                            <td>Tanggal</td>
                                            <td>Keterangan</td>
                                        </tr>
                                        <tr>
                                            <td>1 Mei - 4 Juni 2025</td>
                                            <td>
                                                Pendaftaran melalui link : <a href="https://stthkbp.siakadcloud.com/spmbfront/" target="_blank">https://stthkbp.siakadcloud.com/spmbfront/</a>
                                                <br>(upload semua pendaftaran dan berkas-berkas yang diperlukan)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1 Mei - 4 Juni 2025</td>
                                            <td>Pendaftaran melalui link : <a href="https://stthkbp.siakadcloud.com/spmbfront/" target="_blank">https://stthkbp.siakadcloud.com/spmbfront/</a></td>
                                        </tr>
                                    </table>

                                    <h3 class="mb-20">Simulasi & Ujian</h3>
                                    <p class="mb-20">
                                        
                                    </p>
                                   
                                    <div class="my-4">
                                        <div class="mb-3">
                                            <h3 class="mb-3">Syrat Pendaftaran</h3>
                                            <p>Aliquam facilisis rhoncus nunc, non vestibulum mauris volutpat non.
                                                Vivamus tincidunt accumsan urna, vel aliquet nunc commodo tristique.
                                                Nulla facilisi. Phasellus vel ex nulla. Nunc tristique sapien id mauris
                                                efficitur, porta scelerisque nisl dignissim. Vestibulum ante ipsum
                                                primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed at
                                                mollis tellus. Proin consequat, orci nec bibendum viverra, ante orci
                                                suscipit dolor, et condimentum felis dolor ac lectus.</p>
                                        </div>
                                        <ul class="facility-single-list">
                                            <li><i class="far fa-check"></i>Fusce justo risus placerat in risus eget
                                                tincidunt consequat elit.</li>
                                            <li><i class="far fa-check"></i>Nunc fermentum sem sit amet dolor laoreet
                                                placerat.</li>
                                            <li><i class="far fa-check"></i>Nullam rhoncus dictum diam quis ultrices.
                                            </li>
                                            <li><i class="far fa-check"></i>Integer quis lorem est uspendisse eu augue
                                                porta ullamcorper dictum.</li>
                                            <li><i class="far fa-check"></i>Quisque tristique neque arcu ut venenatis
                                                felis malesuada et.</li>
                                        </ul>
                                    </div>
                                    <div class="my-4">
                                        <h3 class="mb-3">Biaya Registrasi</h3>
                                        <p>Quisque a nisl id sem sollicitudin volutpat. Cras et commodo quam, vel congue
                                            ligula. Orci varius natoque penatibus et magnis dis parturient montes,
                                            nascetur ridiculus mus. Cras quis venenatis neque. Donec volutpat tellus
                                            lobortis mi ornare eleifend. Fusce eu nisl ut diam ultricies accumsan.
                                            Integer lobortis vestibulum nunc id porta. Curabitur aliquam arcu sed ex
                                            dictum, a facilisis urna porttitor. Fusce et mattis nisl. Sed iaculis libero
                                            consequat justo auctor iaculis. Vestibulum sed ex et magna tristique
                                            bibendum. Sed hendrerit neque nec est suscipit, id faucibus dolor convallis.
                                        </p>
                                    </div>
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