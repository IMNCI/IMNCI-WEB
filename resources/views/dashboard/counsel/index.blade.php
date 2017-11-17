@extends('layouts.dashboard')

@section('title', "Counsel the Mother")

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href='{{ asset("dashboard/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css") }}'>
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote-bs3.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/datatables.min.css') }}">
@stop

@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/summernote/summernote.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/dataTables/datatables.min.js') }}"></script>
<script type="text/javascript">
	var content_summernote;
	$(document).ready(function(){
		content_summernote = $('textarea[name="content"]').summernote({
			height: "250px",
			placeholder: "Type here..."
		});

		$('table').dataTable();
	});
	$('#add-title-btn, .edit-title').click(function(){
		manageAddEditUI(this);
	});

	$('.close-btn').click(function(){
		$('#title-form-wrapper').removeClass("bounceInRight");
		$('#title-form-wrapper').addClass("bounceOutRight");
	});

	$('#save-title').on('click', function(event){
		event.preventDefault();
		var title = $('input[name="title"]').val();
		var cohort = $('select[name="age_group_id"]').val();
		var content = $('textarea[name="content"]').val();

		if (title != "" && cohort != "") {
			toastr.warning("Please review content before submiting it");
			$(this).addClass('hidden');
			$('#submit-title').removeClass('hidden');
		}else{
			toastr.error("Both the title and the cohorts have to be filled");
		}
	});

	$('#submit-title').click(function(e){
		e.preventDefault();
		$.ajax({
			url: $('#title-form-wrapper form').attr('action'),
			method: $('#title-form-wrapper form').attr('method'),
			data: $('#title-form-wrapper form').serialize(),
			beforeSend: function(){
				$('#title-form-wrapper').block({
					message: ""
				});
			},
			success: function(){
				toastr.success("Successfully saved title");
				location.reload();
			},
			error: function(){
				$('#title-form-wrapper').unblock();
				toastr.error("There was an error saving title");
			}
		});
	});

	manageAddEditUI = function(that){
		var title = "";
		if($(that).hasClass('remove-title')){
			title = "Delete Title";
			$('#confirm-remove-title').removeClass('hidden');
			$('#submit-title, #save-title').addClass('hidden');
		}else{
			$('#save-title').removeClass('hidden');
			$('#submit-title, #confirm-remove-title').addClass('hidden');
			if (typeof($(that).attr('data-id')) == "undefined") {
				title = "Add Title";
			}else{
				title = "Edit Title";
			}
		}

		if (typeof($(that).attr('data-id')) != "undefined") {
			$('#title-form-wrapper input[name="title_id"]').val($(that).attr('data-id'));
			$('#title-form-wrapper input[name="title"]').val($(that).attr('data-title'));
			$('#title-form-wrapper select[name="age_group_id"]').val($(that).attr('data-cohort'));
			content_summernote.summernote("code", $(that).attr('data-content'));
			if ($(that).attr('data-is-parent') == 1) {
				$('input[name="is_parent"]').attr('checked', true);
			}else{
				$('input[name="is_parent"]').attr('checked', false);
			}
		}else{
			$('#title-form-wrapper input[name="title_id"]').val(0);
			$('#title-form-wrapper input[name="title"]').val("");
			$('#title-form-wrapper select[name="age_group_id"]').val("");
			content_summernote.summernote("code", "");
			$('input[name="is_parent"]').attr("checked", false);
		}

		$('#title-form-wrapper .ibox-title h5').text(title);
		$('#title-form-wrapper').addClass("bounceInRight");
		$('#title-form-wrapper').removeClass("bounceOutRight");
	}
</script>
@stop


@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="tabs-container">
			<ul class="nav nav-tabs">
				<?php $class = "active"; ?>
				@foreach($cohorts as $cohort)
					<li class="{{ $class }}"><a data-toggle="tab" href="#{{ md5($cohort->id) }}">{{ $cohort->age_group }}</a></li>
					<?php $class = ""; ?>
				@endforeach
				<a class="btn btn-primary btn-sm pull-right" id="add-title-btn">Add title</a>
			</ul>

			<div class="tab-content">
				<?php $class = "active"; ?>
				@foreach($cohorts as $cohort)
					<div id="{{ md5($cohort->id) }}" class = "tab-pane {{ $class }}">
						<div class = "panel-body">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Title</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($titles as $title)
									@if($title->age_group_id == $cohort->id)
									<tr>
										<td>{{ $title->title }}</td>
										<td>
											<a class="btn btn-xs btn-white btn-block edit-title" data-id = "{{ $title->id }}" data-cohort = "{{ $title->age_group_id }}" data-title = "{{ $title->title }}" data-content = "{{ $title->content }}" data-is-parent = "{{ $title->is_parent }}">Edit</a>
											@if($title->is_parent == 1)
											<a href = "/counsel-subtitles/{{ $title->id }}" class="btn btn-block btn-white btn-xs">Manage Sub Content</a> 
											@endif
										</td>
									</tr>
									@endif
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<?php $class = ""; ?>
				@endforeach
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="ibox h-built animated bounceOutRight" id="title-form-wrapper">
			<div class="ibox-title">
				<h5>Add Title</h5>
				<div class="pull-right">
					<a class="close-btn text-danger" title="Close this section"><i class = "fa fa-times"></i></a>
				</div>
			</div>
			<div class="ibox-content">
				<form method="POST" action="/api/counsel-title">
					<input type="hidden" name="title_id" value="0" />
					
					<div class="form-group">
						<label class="control-label">Cohort</label>
						<select class="form-control" name="age_group_id" required>
							<option>Select a Cohort</option>
							@foreach($cohorts as $cohort)
							<option value="{{ $cohort->id }}">{{ $cohort->age_group }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label class="control-label">Title</label>
						<input type="text" name="title" class="form-control" required>
					</div>

					<div class="form-group">
						<label>Subtitles</label>
						<div class="checkbox checkbox-primary">
							<input type="checkbox" name="is_parent" id="is_parent" />
							<label class="control-label" for="is_parent">Does this title have subtitle(s)?</label>
						</div>						
					</div>

					<div class="form-group">
						<label class="control-label">Content</label>
						<textarea class="form-control" name="content"></textarea>
					</div>

					<a class="btn btn-success btn-block" id="save-title">Save Title</a>
					<button class="btn btn-primary btn-block hidden" id="submit-title">Submit this Title</button>
					<a class="btn btn-danger btn-block hidden" id="confirm-remove-title">Yes, Remove this Title</a>
				</form>
			</div>
		</div>
	</div>
</div>
@stop