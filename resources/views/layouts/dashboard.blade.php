<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>IMCI - @yield('title')</title>
	@section('page_css')
		<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/font-awesome/css/font-awesome.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/animate.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/style.css') }}">
	@show
</head>
<body class="">
	<div id="wrapper">
		<nav class="navbar-default navbar-static-side" role="navigation">
			<div class="sidebar-collapse">
				<ul class="nav metismenu" id="side-menu">
					<li class="nav-header">
						<div class="dropdown profile-element">
							<span>
                            	<img alt="image" class="img-circle" src="{{ asset('dashboard/img/profile_small.jpg') }}" />
                            </span>
                        	<a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            	<span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong></span>
                            	<span class="text-muted text-xs block">Administrator <b class="caret"></b></span>
                        	</a>
							<ul class="dropdown-menu animated fadeInRight m-t-xs">
								<li><a href="#">Profile</a></li>
								<li><a href="#">Logout</a></li>
							</ul>
                    	</div>
						<div class="logo-element">
							IMCI
						</div>
					</li>
					@section('sidebar')
						<li><a href="{{ route('admin') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a></li>
						<li><a href="{{ route('assess_classify_treatment') }}"><i class="fa fa-clipboard"></i> <span class="nav-label">Assess, Classify and Identify Treatment</span></a></li>
						<li><a href="{{ route('follow_up') }}"><i class="fa fa-stethoscope"></i> <span class="nav-label">Follow Up Care</span></a></li>
						<li><a href="{{ route('reviews') }}"><i class="fa fa-commenting-o"></i> <span class="nav-label">Reviews</span></a></li>
						<li><a href="#"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a></li>
					@show
				</ul>
			</div>
		</nav>

		<div id="page-wrapper" class="gray-bg">
			<div class="row border-bottom">
				<nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
					<div class="navbar-header">
						<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
						<form role="search" class="navbar-form-custom" action="http://webapplayers.com/inspinia_admin-v2.7.1/search_results.html">
							<div class="form-group">
								<input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
							</div>
						</form>
					</div>
				</nav>
			</div>
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-sm-4">
					<h2>@yield('title')</h2>
					<!-- <ol class="breadcrumb">
						<li>
						<a href="index.html">This is</a>
						</li>
						<li class="active">
						<strong>Breadcrumb</strong>
						</li>
					</ol> -->
				</div>
				<div class="col-sm-8">
					<div class="title-action">
						@section('action_area')
						@show
					</div>
				</div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
				@yield('content')
			</div>
		</div>
	</div>
	
	@section('page_js')
		<script src="{{ asset('dashboard/js/jquery-3.1.1.min.js') }}"></script>
		<script src="{{ asset('dashboard/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('dashboard/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
		<script src="{{ asset('dashboard/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
		<script src="{{ asset('dashboard/js/inspinia.js') }}"></script>
		<script src="{{ asset('dashboard/js/plugins/pace/pace.min.js') }}"></script>
	@show
</body>
</html>