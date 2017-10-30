@extends('layouts.dashboard')

@section('title')
Treat the Infact/Child: Ailments:
<small>{{ $title->title }}</small>
@stop

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
				<a id="add-ailment" class="btn btn-primary btn-xs pull-right" href="#">Add Ailment</a>
			</div>
			<div class="ibox-content">
				<table class="table table-hover table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Ailment</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@if($ailments)
						<?php $counter = 1; ?>
						@foreach($ailments as $ailment)
						<tr>
							<td>{{$counter}}</td>
							<td>{{ $ailment->ailment }}</td>
							<td>
								<a class="btn btn-primary btn-xs btn-block" href="/treat_ailment_treatments/{{ $ailment->id }}">Manage Treatments</a>
								<a class="btn btn-default btn-xs btn-block edit-ailment" data-id = "{{ $ailment->id }}" data-ailment = "{{ $ailment->ailment }}" data-content = "{{ $ailment->content }}">Edit</a>
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
		<div class="ibox h-built" id="ailment-form-wrapper">
			<div class="ibox-title">
				<h5>Add Ailment for this title</h5>
			</div>
			<div class="ibox-content">
				<form id="ailment-form" method="POST" action="/api/treat_ailment">
					<input type="hidden" name="id" value="0">
					<input type="hidden" name="treat_titles_id" value="{{ $title->id }}">
					<div class="form-group">
						<label class="control-label" for="ailment">Ailment Title</label>
						<input class="form-control" name = "ailment" id="ailment" required="" />
					</div>

					<div class="form-group">
						<label class="contorl-label" for="content">Content</label>
						<textarea class="form-control" name="content" rows="8"></textarea>
						<span class="help-block m-b-none">**Leave blank if there is none</span>
					</div>

					<button class="btn btn-success btn-sm btn-block">Save Ailment</button>
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
	var content_summernote, ailmentsDataTable;
	$summernote_options = {
		placeholder: 'Type here...',
		height: '250px'
	};
	$(document).ready(function(){
		content_summernote = $('textarea[name="content"]').summernote($summernote_options);
		ailmentsDataTable = $('table').dataTable();
	});

	$('#ailment-form').submit(function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: "POST",
			data: $(this).serialize(),
			beforeSend: function(){
				$('#ailment-form-wrapper').block({
					message: ""
				});
			},
			success: function(res){
				$('#ailment-form-wrapper').unblock();
				toastr.success("Successfully saved ailment", "Success");
				location.reload();
			},
			error: function(){
				$('#ailment-form-wrapper').unblock();
				toastr.error("There was an error saving your ailment", "Error");
			}
		});
	});

	$('#add-ailment').on('click', function(){
		$('.ibox-title h5').text("Add Ailment for this title");

		$('input[name="id"]').val(0);
		$('input[name="ailment"]').val("");
		content_summernote.summernote("code", "");
	});

	$('.edit-ailment').on('click', function(){
		$('.ibox-title h5').text("Editing Ailment");

		$('input[name="id"]').val($(this).attr('data-id'));
		$('input[name="ailment"]').val($(this).attr('data-ailment'));
		content_summernote.summernote("code", $(this).attr('data-content'));
	});
</script>
@stop