@extends('layouts.dashboard')

@section('title')
Treat the Infant/Child: Ailment Treatments:
<small>{{ $ailment->ailment }}
	@if($ailment->treat_title->age_group)
	({{ $ailment->treat_title->age_group->age_group }})
	@endif
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
								<a class="btn btn-default btn-xs btn-block edit-treatment" data-id = "{{ $treatment->id }}" data-treatment = "{{ $treatment->treatment }}" data-content = "{{ $treatment->content }}">Edit</a>
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

					<button class="btn btn-success btn-sm btn-block">Save Treatment</button>
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
				toastr.error("There was an error saving your ailment", "Error");
			}
		});
	});

	$('#add-treatment').on('click', function(){
		$('.ibox-title h5').text("Add Treatments for this Ailment");

		$('input[name="id"]').val(0);
		$('input[name="treatment"]').val("");
		content_summernote.summernote("code", "");
	});

	$('.edit-treatment').on('click', function(){
		$('.ibox-title h5').text("Editing Treatment");

		$('input[name="id"]').val($(this).attr('data-id'));
		$('input[name="treatment"]').val($(this).attr('data-treatment'));
		content_summernote.summernote("code", $(this).attr('data-content'));
	});
</script>
@stop