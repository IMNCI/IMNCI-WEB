@extends('layouts.dashboard')

@section('title')
{{ __('dashboard.treat') }}: Ailments:
<small>{{ $title->title }} ({{ $title->age_group->age_group }})</small>
@stop

@section('page_css')
@parent
{{--  <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/sweetalert/sweetalert.css') }}">  --}}
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote-bs3.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/datatables.min.css') }}">
@stop

@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="/treat">Treat Titles</a></li>
	<li class="active">Ailments</li>
</ol>
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
								@if(count($ailment->treatments) == 0)
								<a class="btn btn-danger btn-xs btn-block delete-ailment" data-id = "{{ $ailment->id }}" data-ailment = "{{ $ailment->ailment }}" data-content = "{{ $ailment->content }}">Remove</a>
								@endif
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
		<div class="ibox h-built animated bounceOutRight" id="ailment-form-wrapper">
			<div class="ibox-title">
				<h5>Add Ailment for this title</h5>
				<div class="pull-right">
					<a class="close-btn text-danger" title="Close this section"><i class = "fa fa-times"></i></a>
				</div>
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

					<button class="btn btn-primary btn-sm btn-block hidden" id="save-ailment">Save Ailment</button>
					<a class="btn btn-success btn-sm btn-block" id="submit-ailment">Submit Ailment</a>
					<a class="btn btn-danger btn-sm btn-block hidden" id="remove-ailment">Remove Ailment</a>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

		$('#submit-ailment').removeClass('hidden');
		$('#remove-ailment').addClass('hidden');
		$('#save-ailment').addClass('hidden');

		$('#ailment-form-wrapper').addClass('bounceInRight');
		$('#ailment-form-wrapper').removeClass('bounceOutRight');

		$('input[name="id"]').val(0);
		$('input[name="ailment"]').val("");
		content_summernote.summernote("code", "");
	});

	$('.edit-ailment').on('click', function(){
		$('.ibox-title h5').text("Editing Ailment");

		$('#submit-ailment').removeClass('hidden');
		$('#remove-ailment').addClass('hidden');
		$('#save-ailment').addClass('hidden');

		$('#ailment-form-wrapper').addClass('bounceInRight');
		$('#ailment-form-wrapper').removeClass('bounceOutRight');

		$('input[name="id"]').val($(this).attr('data-id'));
		$('input[name="ailment"]').val($(this).attr('data-ailment'));
		content_summernote.summernote("code", $(this).attr('data-content'));
	});

	$('.delete-ailment').on('click', function(){
		
		$('.ibox-title h5').text("Remove Ailment");

		$('#submit-ailment').addClass('hidden');
		$('#remove-ailment').removeClass('hidden');
		$('#save-ailment').addClass('hidden');

		$('#ailment-form-wrapper').addClass('bounceInRight');
		$('#ailment-form-wrapper').removeClass('bounceOutRight');

		$('input[name="id"]').val($(this).attr('data-id'));
		$('input[name="ailment"]').val($(this).attr('data-ailment'));
		content_summernote.summernote("code", $(this).attr('data-content'));
	});

	$('#submit-ailment').click(function(){
		toastr.warning("Please verify this content before you save it", "Review");

		$('#submit-ailment').addClass('hidden');
		$('#remove-ailment').addClass('hidden');
		$('#save-ailment').removeClass('hidden');
	});

	$('#remove-ailment').click(function(){
		swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover this ailment",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete)	=>	{
			if (willDelete) {
				$.ajax({
					url: "/api/remove-treat-ailment",
					method: "POST",
					data: {
						id: $('input[name="id"]').val()
					},
					beforeSend: function(){
						$('#ailment-form-wrapper').block({
							message: ""
						});
					},
					success: function(){
						$('#ailment-form-wrapper').unblock();
						toastr.success("Successfully deleted ailment", "Success");
						location.reload();
					},
					error: function(){
						$('#ailment-form-wrapper').unblock();
						toastr.error("There was an error deleting your ailment", "Error");
					}
				});
			}else{
				swal("Deletion cancelled!");
			}
		});
		
	});

	$('.close-btn').click(function(){
		$('#ailment-form-wrapper').removeClass('bounceInRight');
		$('#ailment-form-wrapper').addClass('bounceOutRight');
	});
</script>
@stop