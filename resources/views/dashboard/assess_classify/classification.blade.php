@extends('layouts.dashboard')

@section('title')
Classifications  for Assessment: <small>{{ $assessment->title }}</small>
@stop

@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="/assess_classify_treatment">Assessments</a></li>
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
</style>
@stop

@section('content')
<div class="row">
	<div class="col-lg-4">
		<div class="ibox">
			<div class="ibox-content h-300">
				<h3>
					Classification
				</h3>

				<a href="#" class="btn btn-success btn-sm pull-right">Add Classification</a>
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
										<a class="btn btn-xs btn-white edit-classification" data-id = "{{ $classification->id }}">Edit</a>&nbsp;
										<a class="btn btn-xs btn-white remove-classification" data-id = "{{ $classification->id }}">Remove</a>
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
	<div class="col-lg-4">
		<!-- <div class="ibox" id = "new-classification-box">
			<div class="ibox-content">
				<h3>
					New Classification
				</h3>

				<form class="form-horizontal" method="POST" id="manage-classification-form">
					<div class="form-group">
						<label class="control-label col-sm-2">Classification</label>
						<div class="col-sm-10">
							<input type="text" name="classification" class="form-control">
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
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">Parent</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" data-provide = "typeahead" data-source = "" name = "parent"/>
						</div>
					</div>

					<button class = "btn btn-success" id = "submit-classification">Submit</button>
				</form>
			</div>
		</div> -->
		<div class="ibox" id="signs-box">
			<div class="ibox-content h-300">
				<div class="sk-spinner sk-spinner-double-bounce">
					<div class="sk-double-bounce1"></div>
					<div class="sk-double-bounce2"></div>
				</div>
				<h3>Signs</h3>
				<div class="form-group">
					<textarea class="form-control" name = "signs">
						
					</textarea>
				</div>

				<button id = "save-signs" class = "btn btn-primary btn-block">Save Signs</button>
				<!-- <div class="input-group">
					<input name="sign" type="text" placeholder="Add new sign. " class="input input-sm form-control">
					<span class="input-group-btn">
						<button id="add-sign" type="button" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Add sign</button>
					</span>
				</div>

				<ul class="list-group m-t-md" id="signs">
				</ul> -->
			</div>
		</div>
	</div>

	<div class="col-lg-4">
		<div class="ibox" id="treatment-box">
			<div class="ibox-content h-300">
				<div class="sk-spinner sk-spinner-double-bounce">
					<div class="sk-double-bounce1"></div>
					<div class="sk-double-bounce2"></div>
				</div>
				<h3>Treatment</h3>

				<div class="form-group">
					<textarea class="form-control" name = "treatment">
						
					</textarea>
				</div>

				<button id="save-treatment" class="btn btn-primary btn-block">Save Treatments</button>
				<!-- <div class="input-group">
					<input type="text" name="treatment" placeholder="Add new treatment. " class="input input-sm form-control">
					<span class="input-group-btn">
						<button id="add-treatment" type="button" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Add treatment</button>
					</span>
				</div>

				<ul class="list-group m-t-md" id="treatments">
				</ul> -->
			</div>
		</div>
	</div>
	<!-- <div class="col-lg-4">
		<div class="ibox" id="signs-box">
			<div class="ibox-content h-300">
				<div class="sk-spinner sk-spinner-double-bounce">
					<div class="sk-double-bounce1"></div>
					<div class="sk-double-bounce2"></div>
				</div>
				<h3>Signs</h3>
				<div class="input-group">
					<input name="sign" type="text" placeholder="Add new sign. " class="input input-sm form-control">
					<span class="input-group-btn">
						<button id="add-sign" type="button" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Add sign</button>
					</span>
				</div>

				<ul class="list-group m-t-md" id="signs">
				</ul>
			</div>
		</div>	
	</div>
	<div class="col-lg-4">
		<div class="ibox" id="treatment-box">
			<div class="ibox-content h-300">
				<div class="sk-spinner sk-spinner-double-bounce">
					<div class="sk-double-bounce1"></div>
					<div class="sk-double-bounce2"></div>
				</div>
				<h3>Treatment</h3>
				<div class="input-group">
					<input type="text" name="treatment" placeholder="Add new treatment. " class="input input-sm form-control">
					<span class="input-group-btn">
						<button id="add-treatment" type="button" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Add treatment</button>
					</span>
				</div>

				<ul class="list-group m-t-md" id="treatments">
				</ul>
			</div>
		</div>	
	</div> -->
</div>
@stop

@section('modal')
<div class="modal inmodal fade" id="new_classification_modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">New Classification</h4>
			</div>
			<div class="modal-body form-horizontal">
				<div class="form-group">
					<label class="control-label col-sm-2">Classification</label>
					<div class="col-sm-10">
						<input type="text" name="classification" class="form-control">
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
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">Parent</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" data-provide = "typeahead" data-source = "" name = "parent"/>
					</div>
				</div>
			</div>

			<div class="modal-footer">
			<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" id="save-changes">Save changes</button>
			</div>
		</div>
	</div>
</div>
<div class="modal inmodal fade" id="edit_classification_modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Edit Classification</h4>
			</div>
			<div class="modal-body form-horizontal">
				<div class="form-group">
					<label class="control-label col-sm-2">Classification</label>
					<div class="col-sm-10">
						<input type="text" name="edit_classification" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Category</label>
					<div class="col-sm-10">
						<select class="form-control" name = "edit_category">
							@foreach ($categories as $category)
							<option value="{{$category->id}}" style="color: {{$category->color}}"><i class = "fa fa-circle" ></i> {{$category->classification}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">Parent</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" data-provide = "typeahead" data-source = "" name = "edit_parent"/>
					</div>
				</div>
			</div>

			<input type="hidden" name="id"/>

			<div class="modal-footer">
			<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" id="edit-changes">Save changes</button>
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
		signs_summernote = $('textarea[name="signs"]').summernote();
		treatment_summernote = $('textarea[name="treatment"]').summernote();
	});

	$.get('/api/get-classification-parents/{{ $assessment->id }}', function(data){
		 $('input[name="parent"]').typeahead({ source:data });
		 $('input[name="edit_parent"]').typeahead({ source:data });
	},'json');

	$('#submit-classification').click(function(){
		$('#save-changes').trigger('click');
	});

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

	$('.edit-classification').click(function(e){
		var id = $(this).attr('data-id');
		$.get('/api/classification/' + id, function(data){
			$('input[name="edit_classification"]').val(data.classification);
			$('select[name="edit_category"]').val(data.disease_classification_id);
			$('input[name="edit_parent"]').val(data.parent);
			$('input[name="id"]').val(data.id);

			$('#edit_classification_modal').modal('show');
		});
		e.stopPropagation();
	});

	$('.remove-classification').click(function(e){
		var id = $(this).attr('data-id');
		swal({
			title: "Are you sure?",
			text: "This action cannot be undone",
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

		// window.location = '/signs-and-treatments/' + classification_id;

		// Getting signs and treatment
		$(this).parent().find('li.active').removeClass('active');
		$(this).addClass('active');
		// $('input.classification_id').val(classification_id);

		getSigns();
		getTreatments();
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
</script>
@stop