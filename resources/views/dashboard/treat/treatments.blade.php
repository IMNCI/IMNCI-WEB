@extends('layouts.dashboard')

@section('title')
{{ __('dashboard.treat') }}: Ailment Treatments:
<small>{{ $ailment->ailment }}
	({{ $title->age_group->age_group }})
</small>
@stop

@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="/treat">Treat Titles</a></li>
	<li><a href="/treat_ailments/{{ $ailment->treat_titles_id }}">Ailments</a></li>
	<li class="active">Treatments</li>
</ol>
@stop

@section('content')
<div class="row">
	<div class="col-md-5">
		<div class="ibox h-built">
			<div class="ibox-title">
				<a id="add-treatment" class="btn btn-primary btn-xs pull-right">Add Treatment</a>
			</div>
			<div class="ibox-content">
				<table class="table table-hover table-bordered table-striped">
					<thead>
						<th>Treatment</th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($treatments as $treatment)
						<tr>
							<td>{{ $treatment->treatment }}</td>
							<td>
								<a class="btn btn-default btn-xs btn-block edit-treatment" data-id = "{{ $treatment->id }}" data-treatment = "{{ $treatment->treatment }}" data-content = "{{ $treatment->content }}" data-type = 'edit'>Edit</a>
								<a class="btn btn-danger btn-xs btn-block remove-treatment" data-id = "{{ $treatment->id }}" data-treatment = "{{ $treatment->treatment }}" data-content = "{{ $treatment->content }}" data-type = 'remove'>Remove</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="ibox h-built" id="treatment-form-wrapper">
			<div class="ibox-title">
				<h5>Add Treatments for this Ailment</h5>
			</div>
			<div class="ibox-content">
				<form id="treatment-form" method="POST" action="/api/treat_ailment_treatments">
					<input type="hidden" name="id" value="0">
					<input type="hidden" name="ailment_id" value="{{ $ailment->id }}">
					<div class="form-group">
						<label class="control-label">Treatment</label>
						<input class="form-control" type="text" name="treatment" required />
					</div>

					<div class="form-group">
						<label class="control-label">Content</label>
						<textarea class="form-control" name="content" rows="8"></textarea>
						<span class="help-block m-b-none">**Leave blank if there is none</span>
					</div>

					<button class="btn btn-success btn-sm btn-block" id="save-treatment">Save Treatment</button>
					<a class="btn btn-danger btn-sm btn-block" id="remove-treatment" style="display: none;">Remove Treatment</a>
				</form>
			</div>
		</div>
	</div>
</div>
@stop

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote-bs3.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/datatables.min.css') }}">
<style type="text/css">
	.hidden{
		display: none;
	}
</style>
@stop

@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/summernote/summernote.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/dataTables/datatables.min.js') }}"></script>
<script type="text/javascript">
	var content_summernote, treatmentsDataTable;
	$summernote_options = {
		placeholder: 'Type here...',
		height: '250px'
	};
	$(document).ready(function(){
		content_summernote = $('textarea[name="content"]').summernote($summernote_options);
		treatmentsDataTable = $('table').dataTable();
		$('#remove-treatment').hide();
	});

	$('#treatment-form').submit(function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: "POST",
			data: $(this).serialize(),
			beforeSend: function(){
				$('#treatment-form-wrapper').block({
					message: ""
				});
			},
			success: function(res){
				$('#treatment-form-wrapper').unblock();
				toastr.success("Successfully saved treatment", "Success");
				location.reload();
			},
			error: function(){
				$('#treatment-form-wrapper').unblock();
				toastr.error("There was an error saving this treatment", "Error");
			}
		});
	});

	$('#remove-treatment').on('click', function(e){
		e.preventDefault();
		$.ajax({
			url: "/api/treat_ailment_treatments",
			method: "DELETE",
			data: $('#treatment-form').serialize(),
			beforeSend: function(){
				$('#treatment-form-wrapper').block({
					message: ""
				});
			},
			success: function(res){
				$('#treatment-form-wrapper').unblock();
				toastr.success("Successfully removed treatment", "Success");
				location.reload();
			},
			error: function(){
				$('#treatment-form-wrapper').unblock();
				toastr.error("There was an error removing this treatment", "Error");
			}
		});
	});

	$('#add-treatment').on('click', function(){
		$('.ibox-title h5').text("Add Treatments for this Ailment");

		$('input[name="id"]').val(0);
		$('input[name="treatment"]').val("");
		content_summernote.summernote("code", "");
	});

	$('.edit-treatment, .remove-treatment').on('click', function(){
		var type = $(this).attr('data-type');
		if (type == "edit") {
			$('.ibox-title h5').text("Editing Treatment");
			$('#remove-treatment').hide();
			$('#save-treatment').show();
		}else{
			$('.ibox-title h5').text("Remove Treatment");
			$('#remove-treatment').show();
			$('#save-treatment').hide();
		}
		

		$('input[name="id"]').val($(this).attr('data-id'));
		$('input[name="treatment"]').val($(this).attr('data-treatment'));
		content_summernote.summernote("code", $(this).attr('data-content'));
	});
</script>
@stop