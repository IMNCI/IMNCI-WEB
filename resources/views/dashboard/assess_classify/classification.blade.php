@extends('layouts.dashboard')

@section('title')
Classifications  for Assessment: <small>{{ $assessment->title . " (" . $cohort->age_group . ")" }}</small>
@stop

@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="#" class = 'clickable'>Assessments</a></li>
	<li class="active">Classifications</li>
</ol>
@stop

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/toastr/toastr.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote-bs3.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/sweetalert/sweetalert.css') }}">
<style type="text/css">
.agile-list li.active{
	background: #fff;
}

.hidden{
	display: none;
}
</style>
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		@if(count($classifications) < 1)
			<div class="alert alert-danger">
				There are no classifications for this section
			</div>
		@endif
	</div>
	
	<div class="col-lg-4">
		<div class="ibox">			
			<div class="ibox-content h-300">
				<h3>
					Classification
				</h3>

				<a id="add-classification-btn" class="btn btn-success btn-sm pull-right">Add Classification</a>
				@if ($classifications)
				<ul class="sortable-list connectList agile-list" id="todo">
					@foreach($parents as $parent)
						<h3>{{ $parent->parent }}</h3>
						@foreach ($classifications as $classification)
							@if($classification->parent == $parent->parent)
							<li class="classification-link" style="border-left: 3px solid {{ $classification->color  }}">
								<input type="hidden" class="classification_id" value="{{ $classification->id }}">
								<span>{{ $classification->classification }}</span>
								<div class="agile-detail">
									<span class="pull-right">
										<a class="btn btn-xs btn-white edit-classification" data-id = "{{ $classification->id }}">View/Edit</a>&nbsp;
										<a class="btn btn-xs btn-white remove-classification" data-id = "{{ $classification->id }}" data-classification = '{{ $classification->classification }}'>Remove</a>
									</span>
									@if ($classification->parent)
									{{ $classification->parent }}
									@else
									<br/>
									@endif
								</div>
							</li>
							@endif
						@endforeach
					@endforeach
					
				</ul>
				@else
				@endif
			</div>
		</div>	
	</div>

	<div class="col-lg-8">
		<div class="ibox hbuilt animated hidden" id="manage-classification">
			<div class="ibox-title">
				<h5 class="title">New Classification</h5>
				<div class="pull-right">
					<a class="close-btn text-danger" title="Close this section"><i class = "fa fa-times"></i></a>
				</div>
			</div>
			<div class="ibox-content">

				<form class="form-horizontal" method="POST" id="manage-classification-form">
					<input type="hidden" name="classification_id">
					<div class="form-group">
						<label class="control-label col-sm-2">Classification</label>
						<div class="col-sm-10">
							<input type="text" name="classification" class="form-control" required>
							<label class="error"></label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Category</label>
						<div class="col-sm-10">
							<select class="form-control" name = "category">
								@foreach ($categories as $category)
								<option value="{{$category->id}}" style="color: {{$category->color}}"><i class = "fa fa-circle" ></i> {{$category->classification}}</option>
								@endforeach
							</select>
							<label class="error"></label>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">Parent</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" data-provide = "typeahead" data-source = "" name = "parent"
							required />
							<label class="error"></label>
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-sm-2 control-label">Signs</label>
						<div class="col-sm-10">
							<textarea class="form-control" name = "signs" required></textarea>
							<label class="error"></label>
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-sm-2 control-label">Treatments</label>
						<div class="col-sm-10">
							<textarea class="form-control" name = "treatments" required></textarea>
						</div>
						<label class="error"></label>
					</div>
							
					<button class = "btn btn-block btn-success animated" id = "submit-btn-confirmation">Save Classification, Signs and Treatments</button>
					<button class = "btn btn-block btn-primary hidden animated" id = "submit-btn">Submit</button>
				</form>

			</div>
		</div>
	</div>
</div>
@stop


@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/jquery.blockUI.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/typehead/bloodhound.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/summernote/summernote.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/jquery_validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
	toastr.options = {
		closeButton: true,
		progressBar: true,
		showMethod: 'slideDown',
		timeOut: 4000
	};


	var signs_summernote;
	var treatment_summernote;

	var emptyText = "<p></p><p></p>";
	$(document).ready(function(){
		signs_summernote = $('textarea[name="signs"]').summernote({
			height: "250px",
			placeholder: "Type here..."
		});
		treatment_summernote = $('textarea[name="treatments"]').summernote({
			height: "250px",
			placeholder: "Type here..."
		});

		$('#manage-classification-form').validate();
	});

	$('#submit-btn-confirmation').click(function(e){
		e.preventDefault();
		if ($('textarea[name="signs"]').val() != "" && $('textarea[name="treatments"]').val() != "" && $('input[name="parent"]').val() != "") {
			swal("Review", "Please review this content before submitting it", "info");
			$(this).addClass('hidden');
			$('#submit-btn').removeClass('hidden');
		}else{
			$('#submit-btn').removeAttr('disabled');
			$('#submit-btn').addClass('hidden');
			$('#submit-btn-confirmation').removeClass('hidden');
			toastr.error("Please ensure that all fields have been filled in");
		}
	});

	$('#submit-btn').click(function(e){
		e.preventDefault();
		$(this).attr('disabled', 'disabled');
		
			var classification = $('input[name="classification"]').val();
			var category = $('select[name="category"]').val();
			var parent = $('input[name="parent"]').val();
			var signs = $('textarea[name="signs"]').val();
			var treatments = $('textarea[name="treatments"]').val();
			var classification_id = $('input[name="classification_id"]').val();

			$.ajax({
				url 	: "/api/classification",
				type 	: "POST",
				data 	: {
					classification_id 	: classification_id,
					classification 		: classification,
					category 			: category,
					assessment_id 		: {{ $assessment->id }},
					parent 				: parent,
					signs 				: signs,
					treatments 			: treatments
				},
				beforeSend 	: function(){
					$('#manage-classification').children('.ibox-content').addClass('sk-loading');
				},
				success 	: function(res){
					// initModal();
					$('#manage-classification').children('.ibox-content').removeClass('sk-loading');
					
					if (classification_id == "") {
						toastr.success('Successfully added classification');
					}else{
						toastr.success('Successfully updated classification');
					}
					location.reload();
				},
				error 		: function(){
					$('#submit-btn').attr('disabled', "");
					toastr.error('There was an error adding the classification');
					$('#manage-classification').children('.ibox-content').removeClass('sk-loading');
				}
			});
	});

	$.get('/api/get-classification-parents/{{ $assessment->id }}', function(data){
		 $('input[name="parent"]').typeahead({ source:data });
		 $('input[name="edit_parent"]').typeahead({ source:data });
	},'json');

	$('#submit-classification').click(function(){
		$('#save-changes').trigger('click');
	});

	function getClassificationDetails(id){
		$.ajax({
			url 	: "/api/classification/" + id,
			beforeSend 	: function(){
				$('#manage-classification').children('.ibox-content').addClass('sk-loading');
			},
			success 	: function(res){
				$('#manage-classification').children('.ibox-content').removeClass('sk-loading');
				$('.title').text("View/Edit Classification");
				$('input[name="classification_id"]').val(res.id);
				$('input[name="classification"]').val(res.classification);
				$('select[name="category"]').val(res.disease_classification_id);
				$('input[name="parent"]').val(res.parent);
				signs_summernote.summernote('code', res.signs);
				treatment_summernote.summernote('code', res.treatments);
			},
			error 		: function(){
				toastr.error('There was an error getting classification');
				$('#manage-classification').children('.ibox-content').removeClass('sk-loading');
			}
		});
	}

	$('#save-changes').click(function(){
		var classification = $('input[name="classification"]').val();
		var category = $('select[name="category"]').val();
		var parent = $('input[name="parent"]').val();

		$('#todo li:first').addClass('active');
		// getSigns();
		// getTreatments();
		$.ajax({
			url 	: "/api/classification",
			type 	: "POST",
			data 	: {
				classification 	: classification,
				category 		: category,
				assessment_id 	: {{ $assessment->id }},
				parent 			: parent
			},
			beforeSend 	: function(){
				$('#new-classification-box').children('.ibox-content').addClass('sk-loading');
			},
			success 	: function(){
				// initModal();
				$('#new-classification-box').children('.ibox-content').removeClass('sk-loading');
				toastr.success('Successfully added classification');
				location.reload();
			},
			error 		: function(){
				toastr.error('There was an error adding the classification');
				$('#new-classification-box').children('.ibox-content').removeClass('sk-loading');
			}
		});
	});

	$('#add-classification-btn').click(function(){
		showManageClassification();
		$('h5.title').text("New Classification");
		$('input[name="classification_id"]').val("");
		$('input[name="classification"]').val("");
		$('select[name="category"]').val($('select[name="category option:first"]').val());
		$('input[name="parent"]').val("");
		signs_summernote.summernote('code', "");
		treatment_summernote.summernote('code', "");
	});

	$('.edit-classification').click(function(e){
		showManageClassification();
		var id = $(this).attr('data-id');
		getClassificationDetails(id);
		// $.get('/api/classification/' + id, function(data){
		// 	$('input[name="edit_classification"]').val(data.classification);
		// 	$('select[name="edit_category"]').val(data.disease_classification_id);
		// 	$('input[name="edit_parent"]').val(data.parent);
		// 	$('input[name="id"]').val(data.id);

		// 	$('#edit_classification_modal').modal('show');
		// });
		// e.stopPropagation();
	});

	$('.remove-classification').click(function(e){
		var id = $(this).attr('data-id');
		var classification = $(this).attr('data-classification');
		swal({
			title: "Are you sure?",
			text: classification + " will be deleted together with it's signs and treatments. This action cannot be undone",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, remove it!",
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		}, function(){
			$.get('/api/remove-classification/' + id, function(res){
				swal({
					title: "Success", 
					text: "Classification removed Successfully", 
					type: "success",
					closeOnConfirm: true
				}, function(){
					location.reload();
				});
			});
		});
		e.stopPropagation();
	});
	$('#edit-changes').click(function(e){
		var classification = $('input[name="edit_classification"]').val();
		var category = $('select[name="edit_category"]').val();
		var parent = $('input[name="edit_parent"]').val();
		var id = $('input[name="id"]').val();

		$.ajax({
			url 	: "/api/classification",
			type 	: "POST",
			data 	: {
				classification 	: classification,
				category 		: category,
				id 				: id,
				parent 			: parent
			},
			beforeSend 	: function(){
				$('#edit_classification_modal .modal-content').block();
			},
			success 	: function(){
				initModal();
				$('#edit_classification_modal').modal('hide');
				toastr.success('Successfully editted classification');
				$('#edit_classification_modal .modal-content').unblock();
				location.reload();
			},
			error 		: function(){
				toastr.error('There was an error adding the classification');
				$('#edit_classification_modal .modal-content').unblock();
			}
		});
	});

	$('.classification-link').click(function(){
		var classification_id = $(this).find('.classification_id').val();
		showManageClassification();

		// window.location = '/signs-and-treatments/' + classification_id;

		// Getting signs and treatment
		$(this).parent().find('li.active').removeClass('active');
		$(this).addClass('active');
		// $('input.classification_id').val(classification_id);

		getClassificationDetails(classification_id);
	});

	function initModal(){
		$('input[name="parent"]').val("");
		$('input[name="classification"]').val("");
		$('select[name="category"]').val($('select[name="category"] option:first').val());
	}

	function getSigns(){
		var selected = $('#todo').find('li.active');
		if (selected.length >= 1) {
			var classification_id_input;
			if (selected.length == 1) {
				classification_id_input = selected.find('input.classification_id');
			}else{
				classification_id_input = selected[0].find('input.classification_id');
			}

			var classification_id = classification_id_input.val();

			$('#signs-box').children('.ibox-content').addClass('sk-loading');
			$.get('/api/signs/' + classification_id, function(res){
				$('#signs-box').children('.ibox-content').removeClass('sk-loading');
				// $('#signs').html("");
				if (res.length > 0) {
					$.each(res, function(key, value){
						// $('#signs').append('<li class="list-group-item">'+value.sign+'</li>');
						signs_summernote.summernote('code', value.sign);
					});
				}else{
					signs_summernote.summernote('code', "<p></p>");
				}
			});
		}else{
			alert('Could not find data');
		}
	}

	function showManageClassification(){
		$('#submit-btn-confirmation').removeClass('hidden');
		$('#submit-btn').addClass('hidden');
		$('#manage-classification').removeClass('hidden');
		$('#manage-classification').removeClass('bounceOutRight');
		$('#manage-classification').addClass('bounceInRight');
	}

	function getTreatments(){
		var selected = $('#todo').find('li.active');
		if (selected.length >= 1) {
			var classification_id_input;
			if (selected.length == 1) {
				classification_id_input = selected.find('input.classification_id');
			}else{
				classification_id_input = selected[0].find('input.classification_id');
			}

			var classification_id = classification_id_input.val();

			$('#treatment-box').children('.ibox-content').addClass('sk-loading');

			$.get('/api/treatments/' + classification_id, function(res){
				$('#treatment-box').children('.ibox-content').removeClass('sk-loading');
				// $('#treatments').html("");
				if (res.length > 0) {
					$.each(res, function(key, value){
						// $('#treatments').append('<li class="list-group-item">'+value.treatment+'</li>');
						treatment_summernote.summernote('code', value.treatment);
					});
				}else{
					treatment_summernote.summernote('code', "<p></p>");
				}
			});
		}else{
			alert('Could not find data');
		}
	}

	$('#save-signs').click(function(){
		var sign = $('textarea[name="signs"]').val();
		if (sign != "") {
			classification_id = $('li.active').find('input.classification_id').val();
			if(classification_id != ""){
				$('#signs-box').children('.ibox-content').addClass('sk-loading');
				$.post('/api/sign', {sign: sign, classification_id : classification_id}, function(res){
					toastr.success("Successfully saved sign");
					$('#signs-box').children('.ibox-content').removeClass('sk-loading');
				});
			}else{
				alert("Please pick a classification");
			}
		}else{
			alert("Please enter a sign");
		}
	});

	$('#save-treatment').click(function(){
		var treatment = $('textarea[name="treatment"]').val();
		if (treatment != "") {
			classification_id = $('li.active').find('input.classification_id').val();
			if(classification_id != ""){
				$('#treatment-box').children('.ibox-content').addClass('sk-loading');
				$.post('/api/treatment', {treatment: treatment, classification_id : classification_id}, function(res){
					$('#treatment-box').children('.ibox-content').removeClass('sk-loading');
					toastr.success("Successfully saved treatment");
					// $('input[name="treatment"]').val("");
					// getTreatments();
				});
			}else{
				alert("Please pick a classification");
			}
		}else{
			alert("Please enter a treatment");
		}
	});

	$('.close-btn').click(function(){
		$('#manage-classification').removeClass('bounceInRight');
		$('#manage-classification').addClass('bounceOutRight');
	});
</script>
@stop