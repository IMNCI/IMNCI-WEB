@extends('layouts.dashboard')

@section('title', 'Treat the Child/Infant')

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote-bs3.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/datatables.min.css') }}">
@stop

@section('content')
<div class="row">
	<div class="col-md-7">
		<div class="ibox h-built">
			<div class="ibox-title">
				<a id="add-title" class="btn btn-primary btn-xs pull-right" href="#">Add Title</a>
			</div>
			<div class="ibox-content">
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th style="width: 80%;">Title</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@if($titles)
						<?php $counter = 1; ?>
						@foreach($titles as $title)
						<tr>
							<td>{{$counter}}</td>
							<td>{{ $title->title }}</td>
							<td>
								<a class="btn btn-primary btn-xs btn-block" href="/treatments/{{ $title->id }}">Manage Treatments</a>
								<a class="btn btn-default btn-xs btn-block edit-title" data-id = "{{ $title->id }}" data-title = "{{ $title->title }}" data-guide = "{{ $title->guide }}">Edit</a>
								<!-- <a class="btn btn-danger btn-xs btn-block delete-title" data-id = "{{ $title->id }}">Remove</a> -->
							</td>
						</tr>
						<?php $counter++; ?>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="ibox h-built" id="title-form-wrapper">
			<div class="ibox-title">
				<h5>Add Title</h5>
			</div>
			<div class="ibox-content">
				<form method="POST" action="/api/title" id="title-form">
					<input type="hidden" name="id" value="0">
					<div class="form-group">
						<label class="control-label">Title</label>
						<input class="form-control" name="title" type="text" />
					</div>

					<div class="form-group">
						<label class="control-label">Guide</label>
						<textarea class="form-control" name = "guide" rows="8"></textarea>
					</div>

					<button class="btn btn-success btn-sm btn-block" id="save-title">Save Title</button>
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

		$('input[name="id"]').val(0);
		$('input[name="title"]').val("");
		guide_summernote.summernote("code", "");
	});

	$('.edit-title').on('click', function(){
		$('#title-form-wrapper .ibox-title h5').text("Editing Title");

		$('input[name="id"]').val($(this).attr('data-id'));
		$('input[name="title"]').val($(this).attr('data-title'));
		guide_summernote.summernote("code", $(this).attr('data-guide'));
	});

	// $('.delete-title')
</script>
@stop