@extends('layouts.dashboard')

@section('title', 'Treat the Child/Infant')

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote-bs3.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/datatables.min.css') }}">
<style type="text/css">
	/*.hidden{
		display: none;
	}*/
</style>
@stop

@section('content')
<div class="row">
	<div class="col-md-7">
		<div class="ibox h-built">
			<!-- <div class="ibox-title"> -->
				<a id="add-title" class="btn btn-primary btn-xs pull-right" href="#">Add Title</a>
			<!-- </div> -->
			<!-- <div class="ibox-content"> -->
				<div class="tabs-container">
					<ul class="nav nav-tabs">
						<?php $class = "active"; ?>
						@foreach($cohorts as $cohort)
							<li class="{{ $class }}"><a data-toggle="tab" href="#{{ md5($cohort->id) }}">{{ $cohort->age_group }}</a></li>
							<?php $class = ""; ?>
						@endforeach
					</ul>

					<div class="tab-content">
						<?php $class = "active"; ?>
						@foreach($cohorts as $cohort)
							<div id="{{ md5($cohort->id) }}" class = "tab-pane {{ $class }}">
								<div class = "panel-body">
									<table class="table table-hover table-bordered table-striped">
										<thead>
											<tr>
												<th>#</th>
												<th>Title</th>
												<th>Cohort</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											@if($titles)
											<?php $counter = 1; ?>
											@foreach($titles as $title)
											@if($title->age_group->id == $cohort->id)
											<tr>
												<td>{{$counter}}</td>
												<td>{{ $title->title }}</td>
												<td>{{ $title->age_group->age_group }}</td>
												<td>
													<a class="btn btn-primary btn-xs btn-block" href="/treat_ailments/{{ $title->id }}">Manage Ailments / Treatments</a>
													<a class="btn btn-default btn-xs btn-block edit-title" data-id = "{{ $title->id }}" data-title = "{{ $title->title }}" data-guide = "{{ $title->guide }}" data-cohort-id = "{{ $title->age_group_id }}">Edit</a>
													@if(count($title->treat_ailments) == 0)
													<a class="btn btn-danger btn-xs btn-block delete-title" data-id = "{{ $title->id }}" data-title = "{{ $title->title }}" data-guide = "{{ $title->guide }}" data-cohort-id = "{{ $title->age_group_id }}">Remove</a>
													@endif
												</td>
											</tr>
											<?php $counter++; ?>
											@endif
											@endforeach
											@endif
										</tbody>
									</table>
								</div>
							</div>
						<?php $class = ""; ?>
						@endforeach
					</div>
				</div>
				
			<!-- </div> -->
		</div>
	</div>
	<div class="col-md-5">
		<div class="ibox h-built animated bounceOutRight" id="title-form-wrapper">
			<div class="ibox-title">
				<h5>Add Title</h5>
				<div class="pull-right">
					<a class="close-btn text-danger" title="Close this section"><i class = "fa fa-times"></i></a>
				</div>
			</div>
			<div class="ibox-content">
				<form method="POST" action="/api/title" id="title-form">
					<input type="hidden" name="id" value="0">
					<div class="form-group">
						<label class="control-label">Title</label>
						<input class="form-control" name="title" type="text" />
					</div>

					<div class="form-group">
						<label class="control-label">Cohort</label>
						<select class = "form-control" name="age_group_id" required="">
							<option value="0">Select a cohort...</option>
							@foreach($cohorts as $cohort)
							<option value="{{ $cohort->id }}">{{$cohort->age_group}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label class="control-label">Guide</label>
						<textarea class="form-control" name = "guide" rows="8"></textarea>
					</div>

					<button class="btn btn-primary btn-sm btn-block hidden" id="save-title">Save Title</button>
					<a class="btn btn-success btn-sm btn-block" id="submit-title">Submit Title</a>
					<a class="btn btn-danger btn-sm btn-block hidden" id="remove-title">Remove Title</a>
				</form>
			</div>
		</div>
	</div>
</div>
@stop

@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/summernote/summernote.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/dataTables/datatables.min.js') }}"></script>

<script type="text/javascript">
	var guide_summernote, titlesDataTable;
	$summernote_options = {
		placeholder: 'Type here...',
		height: '250px'
	};
	$(document).ready(function(){
		guide_summernote = $('textarea[name="guide"]').summernote($summernote_options);
		titlesDataTable = $('table').dataTable();
	});

	$('#submit-title').on('click', function(){
		toastr.warning("Please review your content before you submit it!", "Review");
		$(this).addClass('hidden');
		$('#save-title').removeClass('hidden');
	});

	$('#title-form').submit(function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: "POST",
			data: $(this).serialize(),
			beforeSend: function(){
				$('#title-form-wrapper').block({
					message: ""
				});
			},
			success: function(res){
				$('#title-form-wrapper').unblock();
				toastr.success("Successfully saved title", "Success");
				location.reload();
			},
			error: function(){
				$('#title-form-wrapper').unblock();
				toastr.error("There was an error saving your title", "Error");
			}
		});
	});

	$('#add-title').on('click', function(){
		$('#title-form-wrapper .ibox-title h5').text("Add Title");

		$('#title-form-wrapper').addClass('bounceInRight');
		$('#title-form-wrapper').removeClass('bounceOutRight');

		$('input[name="id"]').val(0);
		$('input[name="title"]').val("");
		$('select[name="age_group_id"]').val(0);
		guide_summernote.summernote("code", "");

		$('#submit-title').removeClass('hidden');
		$('#save-title').addClass('hidden');
		$('#remove-title').addClass('hidden');
	});

	$('.edit-title').on('click', function(){
		$('#title-form-wrapper .ibox-title h5').text("Editing Title");

		$('#title-form-wrapper').addClass('bounceInRight');
		$('#title-form-wrapper').removeClass('bounceOutRight');

		$('input[name="id"]').val($(this).attr('data-id'));
		$('input[name="title"]').val($(this).attr('data-title'));
		$('select[name="age_group_id"]').val($(this).attr('data-cohort-id'));
		guide_summernote.summernote("code", $(this).attr('data-guide'));

		$('#submit-title').removeClass('hidden');
		$('#save-title').addClass('hidden');
		$('#remove-title').addClass('hidden');
	});

	$('.delete-title').on('click', function(){
		$('#title-form-wrapper .ibox-title h5').text("Delete this Title");

		$('#title-form-wrapper').addClass('bounceInRight');
		$('#title-form-wrapper').removeClass('bounceOutRight');

		$('input[name="id"]').val($(this).attr('data-id'));
		$('input[name="title"]').val($(this).attr('data-title'));
		$('select[name="age_group_id"]').val($(this).attr('data-cohort-id'));
		guide_summernote.summernote("code", $(this).attr('data-guide'));

		$('#submit-title').addClass('hidden');
		$('#save-title').addClass('hidden');
		$('#remove-title').removeClass('hidden');
	});

	$('#remove-title').on('click', function(){
		$.ajax({
			url: "/api/remove-treat-title",
			method: "POST",
			data: {
				id: $('input[name="id"]').val()
			},
			beforeSend: function(){
				$('#title-form-wrapper').block({
					message: ""
				});
			},
			success: function(){
				$('#title-form-wrapper').unblock();
				toastr.success("Successfully deleted title", "Success");
				location.reload();
			},
			error: function(){
				$('#title-form-wrapper').unblock();
				toastr.error("There was an error deleting your title", "Error");
			}
		});
	});

	$('.close-btn').click(function(){
		$('#title-form-wrapper').removeClass('bounceInRight');
		$('#title-form-wrapper').addClass('bounceOutRight');
	});

	// $('.delete-title')
</script>
@stop