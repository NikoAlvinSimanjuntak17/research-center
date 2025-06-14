<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>@yield('title')</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Global stylesheets -->
	<link href="{{ asset('admin/assets2/fonts/inter/inter.css')}}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/assets2/icons/phosphor/styles.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/assets/css/ltr/all.min.css')}}" id="stylesheet" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ asset('admin/assets2/demo/demo_configurator.js')}}"></script>
	<script src="{{ asset('admin/assets2/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
	<!-- /core JS files -->

	<script src="{{ asset('admin/assets/js/app.js')}}"></script>
	<!-- Theme JS files -->
	<script src="{{ asset('admin/assets2/js/vendor/visualization/d3/d3.min.js')}}"></script>
	<script src="{{ asset('admin/assets2/js/vendor/visualization/d3/d3_tooltip.js')}}"></script>

	<script src="{{ asset('admin/assets2/js/jquery/jquery.min.js')}}"></script>
	<script src="{{ asset('admin/assets2/js/vendor/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{ asset('admin/assets2/demo/pages/dashboard.js')}}"></script>
	<script src="{{ asset('admin/assets2/demo/charts/pages/dashboard/streamgraph.js')}}"></script>
	<script src="{{ asset('admin/assets2/demo/charts/pages/dashboard/sparklines.js')}}"></script>
	<script src="{{ asset('admin/assets2/demo/charts/pages/dashboard/lines.js')}}"></script>
	<script src="{{ asset('admin/assets2/demo/charts/pages/dashboard/areas.js')}}"></script>
	<script src="{{ asset('admin/assets2/demo/charts/pages/dashboard/donuts.js')}}"></script>
	<script src="{{ asset('admin/assets2/demo/charts/pages/dashboard/bars.js')}}"></script>
	<script src="{{ asset('admin/assets2/demo/charts/pages/dashboard/progress.js')}}"></script>
	<script src="{{ asset('admin/assets2/demo/charts/pages/dashboard/heatmaps.js')}}"></script>
	<script src="{{ asset('admin/assets2/demo/charts/pages/dashboard/pies.js')}}"></script>
	<script src="{{ asset('admin/assets2/demo/charts/pages/dashboard/bullets.js')}}"></script>
	<script src="{{ asset('admin/assets2/demo/pages/datatables_basic.js')}}"></script>
	<!-- <script src="{{ asset('admin/assets2/js/vendor/editors/ckeditor/ckeditor_classic.js')}}"></script>
	<script src="{{ asset('admin/assets2/demo/pages/editor_ckeditor_classic.js')}}"></script> -->
	<script src="{{ asset('admin/assets2/js/vendor/editors/ckeditor/ckeditor_document.js')}}"></script>
	<script src="{{ asset('admin/assets2/demo/pages/editor_ckeditor_document.js')}}"></script>
	<!-- /theme JS files -->

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body>
	@include('Admin.Layouts.topbar')
	@include('Admin.Layouts.sidebar')
	@include('Admin.Layouts.header')

	<div class="content-wrapper">
		<div class="content-inner">
			<!-- Content area -->
			<div class="content">
				@yield('content')
			</div>
		</div>
	</div>
	@include('Admin.Layouts.footer')


	@stack('scripts')

</body>