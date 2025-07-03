<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>TSTH2</title>

	<!-- Global stylesheets -->
	<link href="{{ URL::asset('backend/assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset('backend/assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset('backend/assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset('backend/assets/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset('backend/assets/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset('backend/assets/icons/material/styles.min.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ URL::asset('backend/assets/demo/demo_configurator.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{ URL::asset('backend/assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>

	<script src="{{ URL::asset('backend/assets/js/app.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/dashboard.js') }}"></script>
	<!-- <script src="{{ URL::asset('backend/assets/demo/charts/pages/dashboard/streamgraph.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/charts/pages/dashboard/sparklines.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/charts/pages/dashboard/lines.js') }}"></script>	
	<script src="{{ URL::asset('backend/assets/demo/charts/pages/dashboard/areas.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/charts/pages/dashboard/donuts.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/charts/pages/dashboard/bars.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/charts/pages/dashboard/progress.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/charts/pages/dashboard/heatmaps.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/charts/pages/dashboard/pies.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/charts/pages/dashboard/bullets.js') }}"></script> -->
	<!-- /theme JS files -->

	<!-- Theme JS files -->
	<script src="{{ URL::asset('backend/assets/js/jquery/jquery.min.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/datatables_data_sources.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/timelines.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/js/vendor/ui/fullcalendar/main.min.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/js/vendor/visualization/echarts/echarts.min.js') }}"></script>

	<script src="{{ URL::asset('backend/assets/demo/charts/echarts/bars/tornado_negative_stack.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/charts/pages/timelines/daily_statistics.js') }}"></script>

	<script src="{{ URL::asset('backend/assets/js/vendor/editors/quill/quill.min.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/editor_quill.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_buttons.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_tooltips.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_modals.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_popups.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_pagination.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_progress.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_notifications.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_thumbnails.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_labels_badges.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_list_groups.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_navigation.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_forms.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_tables.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_accordion.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_carousel.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_dropdowns.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_list.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_grid.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_scrollspy.js') }}"></script>
	<script src="{{ URL::asset('backend/assets/demo/pages/components_popovers.js') }}"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Main navbar -->
	@include('layout.backend.navbar')
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		@include('layout.backend.sidebar')
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Breadcrumb header -->
				@include('layout.backend.breadcrumb')
				<!-- /Breadcrumb header -->


				<!-- Content area -->
				<div class="content">
                    @yield('content')
				</div>
				<!-- /content area -->


				<!-- Footer -->
				@include('layout.backend.footer')
				<!-- /footer -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	@stack('scripts')

</body>
</html>