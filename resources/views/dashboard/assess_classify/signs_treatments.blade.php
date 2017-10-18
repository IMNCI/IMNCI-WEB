@extends('layouts.dashboard')
@section('title')
Signs and Treatment <small>{{ $classification->classification }}</small>
@stop

@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="/assess_classify_treatment">Assessments</a></li>
	<li><a href="/classifications/{{ $classification->assessment_id }}">Classifications</a></li>
	<li class="active">Signs & Treatments</li>
</ol>
@stop

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote-bs3.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/toastr/toastr.min.css') }}">
@stop

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="ibox" id="signs-box">
			<div class="ibox-content">
				<div class="sk-spinner sk-spinner-double-bounce">
					<div class="sk-double-bounce1"></div>
					<div class="sk-double-bounce2"></div>
				</div>
				<h3>Signs</h3>
				<div class="form-group">
					<textarea class="form-control" name = "signs">
						@if($signs)
							{{ $signs->sign }}
						@endif
					</textarea>
				</div>

				<button id = "save-signs" class = "btn btn-primary">Save Signs</button>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="ibox" id="treatment-box">
			<div class="ibox-content">
				<div class="sk-spinner sk-spinner-double-bounce">
					<div class="sk-double-bounce1"></div>
					<div class="sk-double-bounce2"></div>
				</div>
				<h3>Treatment</h3>

				<div class="form-group">
					<textarea class="form-control" name = "treatment">
						@if($treatment)
							{{ $treatment->treatment }}
						@endif
					</textarea>
				</div>

				<button id="save-treatment" class="btn btn-primary">Save Treatments</button>
			</div>
		</div>
	</div>
</div>
@stop

@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/summernote/summernote.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/jquery.blockUI.js') }}"></script>

<script type="text/javascript">
	var signs_summernote;
	var treatment_summernote;

	toastr.options = {
		closeButton: true,
		progressBar: true,
		showMethod: 'slideDown',
		timeOut: 4000
	};

	var emptyText = "<p></p><p></p>";
	$(document).ready(function(){
		signs_summernote = $('textarea[name="signs"]').summernote();
		treatment_summernote = $('textarea[name="treatment"]').summernote();
	});


	$('#save-signs').click(function(){
		$.ajax({
			url: "/api/sign",
			method: "POST",
			data: {
				sign : $('textarea[name="signs"]').val(),
				classification_id : {{ $classification->id }}
			},
			beforeSend: function(){
				$('#signs-box').children('.ibox-content').addClass('sk-loading');
			},
			success: function(){
				toastr.success('Successfully saved classification sign');
				$('#signs-box').children('.ibox-content').removeClass('sk-loading');
			},
			error: function(){
				toastr.error("There was an error saving the sign. Please try again");
				$('#signs-box').children('.ibox-content').removeClass('sk-loading');
			}
		});
	});

	$('#save-treatment').click(function(){
		$.ajax({
			url: "/api/treatment",
			method: "POST",
			data: {
				treatment : $('textarea[name="treatment"]').val(),
				classification_id : {{ $classification->id }}
			},
			beforeSend: function(){
				$('#treatment-box').children('.ibox-content').addClass('sk-loading');
			},
			success: function(){
				toastr.success('Successfully saved classification treatment');
				$('#treatment-box').children('.ibox-content').removeClass('sk-loading');
			},
			error: function(){
				toastr.error("There was an error saving the treatment. Please try again");
				$('#treatment-box').children('.ibox-content').removeClass('sk-loading');
			}
		});
	});
</script>
@stop