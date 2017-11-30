<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>IMCI - @yield('title')</title>
	@section('page_css')
		<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/font-awesome/css/font-awesome.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/toastr/toastr.min.css') }}">
	@show
	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/animate.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/style.css') }}">
	<style type="text/css">
		.breadcrumb > li a{
			color: #337AB7 !important;
		}
	</style>
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
								<li><a class="logout" href="{{ route('logout') }}">Logout</a></li>
							</ul>
                    	</div>
						<div class="logo-element">
							IMCI
						</div>
					</li>
					@section('sidebar')
						<li><a href="{{ route('admin') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a></li>
						<li><a href="{{ route('assess_classify_treatment') }}"><i class="fa fa-clipboard"></i> <span class="nav-label">Assess, Classify and Identify Treatment</span></a></li>
						<li><a href="{{ route('treat') }}"><i class="fa fa-heartbeat"></i> <span class="nav-label">Treat the Infant/Child</span></a></li>
						<li><a href="{{ route('follow_up') }}"><i class="fa fa-stethoscope"></i> <span class="nav-label">Follow Up Care</span></a></li>
						<li><a href="{{ route('counsel_the_mother') }}"><i class="fa fa-child"></i> <span class="nav-label">Counsel the Mother</span></a></li>
						<li><a href="{{ route('hiv_care') }}"><i class="fa fa-user-md"></i> <span class="nav-label">HIV Care For Children</span></a></li>
						<li><a href="{{ route('gallery') }}"><i class="fa fa-picture-o"></i> <span class="nav-label">Gallery</span></a></li>
						<li><a href="{{ route('glossary') }}"><i class="fa fa-book"></i> <span class="nav-label">Glossary</span></a></li>
						<li><a href="{{ route('reviews') }}"><i class="fa fa-commenting-o"></i> <span class="nav-label">Reviews</span></a></li>
						<li><a href="{{ route('logout') }}" class="logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a></li>
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
				<div class="col-sm-10">
					<h2>@yield('title')<small>@yield('subtitle')</small></h2>
					@yield('breadcrumb')
					<!-- <ol class="breadcrumb">
						<li>
						<a href="index.html">This is</a>
						</li>
						<li class="active">
						<strong>Breadcrumb</strong>
						</li>
					</ol> -->
				</div>
				<div class="col-sm-2">
					<div class="title-action">
						@section('action_area')
						@show
					</div>
				</div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
				@yield('content')
			</div>

			@yield('modal')
		</div>
	</div>

	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
	
	@section('page_js')
		<script src="{{ asset('dashboard/js/jquery-3.1.1.min.js') }}"></script>
		<script src="{{ asset('dashboard/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('dashboard/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
		<script src="{{ asset('dashboard/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
		<script src="{{ asset('dashboard/js/plugins/toastr/toastr.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('dashboard/js/jquery.blockUI.js') }}"></script>
		<script type="text/javascript">
			toastr.options = {
				closeButton: true,
				progressBar: true,
				showMethod: 'slideDown',
				timeOut: 4000
			};

			$('.clickable').click(function(){
				parent.history.back();
				return false;
			});

			$('.logout').click(function(event){
				event.preventDefault(); 
				document.getElementById('logout-form').submit();
			});

			function readURL(input) {
				var ValidImageTypes = ["image/bmp", "image/jpeg", "image/png"];
				if (input.files && input.files[0]) {
					var fileType = input.files[0]["type"];
					if ($.inArray(fileType, ValidImageTypes) < 0) {
						toastr.error("The file type you are trying to upload is not allowed");
						$('#remove-screenshot-from-file').trigger('click');
					}else{
						var reader = new FileReader();
						reader.onload = function(e) {
							console.log(e);
							$('#screenshot-preview').attr('src', e.target.result);
							$('input[name="thumb"]').val(e.target.result);
						}

						reader.readAsDataURL(input.files[0]);
					}
				}else{
					$('#screenshot-preview').attr('src', "#");
					$('input[name="thumb"]').val("");
				}
			}
		</script>
	@show
	<script src="{{ asset('dashboard/js/inspinia.js') }}"></script>
	<script src="{{ asset('dashboard/js/plugins/pace/pace.min.js') }}"></script>
</body>
</html>