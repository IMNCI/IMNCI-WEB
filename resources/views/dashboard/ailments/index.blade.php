@extends('layouts.dashboard')

@section('title', 'Ailments')

@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="#" class = 'clickable'>Follow Up Care</a></li>
	<li class="active">Ailments</li>
</ol>
@stop

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/sweetalert/sweetalert.css') }}">
@stop


@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="ibox">
			<div class="ibox-content">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label class="control-label">Cohort</label>
							<select id="cohort" class="form-control">
								<option value="0">All Cohorts...</option>
								@if($cohorts)
								@foreach($cohorts as $cohort)
								<option value="{{ $cohort->id }}">{{ $cohort->age_group }}</option>
								@endforeach
								@endif
							</select>
						</div>
					</div>

					<a class="btn btn-sm btn-primary pull-right" id="add-ailment">Add Ailment</a>
				</div>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Ailment</th>
								<th>Cohort</th>
								<th>Follow Up</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody id="cohorts-table"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="ibox float-e-margins animated fadeOut" id="manage-ailment">
			<div class="ibox-title">
				<h5>New Ailment</h5>
			</div>
			<div class="ibox-content">
				<form id="manage-ailment-form">
					<div class="form-group">
						<label class="control-label">Cohort</label>
						<select class="form-control" name="age_group_id" required>
							@if($cohorts)
							@foreach($cohorts as $cohort)
							<option value="{{ $cohort->id }}">{{ $cohort->age_group }}</option>
							@endforeach
							@endif
						</select>
					</div>

					<input type="hidden" name="ailment_id">

					<div class="form-group">
						<label class="control-label">Ailment</label>
						<input class="form-control" name="ailment" placeholder="Ailment" required/>
					</div>

					<div class="form-group">
						<label class="control-label" placeholder = "Description comes here..." required>Description</label>
						<textarea class="form-control" rows="8" name="description"></textarea>
					</div>

					<button class="btn btn-sm btn-block btn-success" id="save-ailment">Save Ailment</button>
				</form>
			</div>
		</div>
	</div>
</div>
@stop

@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script type="text/javascript">
	table = $('#cohorts-table');
	$(document).ready(function(){
		getAilmentsTable($('#cohort').val());
	});

	initAddAilment = function(){
		$('.ibox-title h5').text('Add Ailment');
		$('#manage-ailment select[name="age_group_id"]').val($(this).attr('data-cohort'));
		$('#manage-ailment input[name="ailment"]').val("");
		$('#manage-ailment textarea[name="descriotion"]').val("");
		$('#manage-ailment input[name="ailment_id"]').val("");
	}

	$('#add-ailment').click(function(){
		initAddAilment();
		$('#manage-ailment').removeClass('fadeOut');
		$('#manage-ailment').addClass('bounceIn');
	});

	$('#cohorts-table').on('click', 'a.edit-ailment', function(){
		$('.ibox-title h5').text('Edit Ailment');
		$('#manage-ailment').removeClass('fadeOut');
		$('#manage-ailment').addClass('bounceIn');
		$('#manage-ailment select[name="age_group_id"]').val($(this).attr('data-cohort'));
		$('#manage-ailment input[name="ailment"]').val($(this).attr('data-ailment'));
		$('#manage-ailment textarea[name="descriotion"]').val($(this).attr('data-description'));
		$('#manage-ailment input[name="ailment_id"]').val($(this).attr('data-id'));
		var id = $(this).attr('data-id');
	});

	$('#cohorts-table').on('click', 'a.delete-ailment', function(){
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
			$.ajax({
				url: '/api/delete-ailment/' + id,
				success: function(res){
					if (res.status == true) {
						swal("Success", "Successfully deleted ailment", "success");
						getAilmentsTable($('#cohort').val());
					}else{
						swal("Error", res.message, "error");
					}
				},
				error: function(){
					swal("Error", "There was an error deleting this ailment", "error");
				}
			});
		});
	});

	$('#cohort').on('change', function(){
		getAilmentsTable($(this).val());
	});

	$('#manage-ailment-form').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url : "/api/ailment",
			method: "POST",
			data: $('#manage-ailment-form').serialize(),
			beforeSend: function(){
				$('#manage-ailment-form').block();
			},
			success: function(){
				toastr.success("Successfully saved details");
				$('#manage-ailment-form').unblock();
				getAilmentsTable($("#cohort").val());
			},
			error: function(){
				$('#manage-ailment-form').unblock();
				toastr.error("There was an error saving details");
			}
		})
		.done(function(){
			
		});
	});

	getAilmentsTable = function(cohort){
		$.ajax({
			url: "/api/ailments/" + cohort,
			beforeSend: function(){
				// TODO
				table.parent().block({
					message: "<span class='loading box-bounce'></span>"
				});
			},
			success: function(res){
				var table_row = "";
				var counter =1;
				$.each(res, function(key, ailment){
					table_row += "<tr>";
					table_row += "<td>"+counter+"</td>";
					table_row += "<td>"+ailment.ailment+"</td>";
					table_row += "<td>"+ailment.age_group+"</td>";
					if (ailment.advice != null || ailment.treatment != null) {
						table_row += "<td><span class = 'label label-primary'>Available</span></td>";
					}else{
						table_row += "<td><span class = 'label label-danger'>Unavailable</span></td>";
					}
					table_row += "<td>";
					table_row += "<a href = '#' class = 'btn btn-xs btn-default edit-ailment' data-id = '"+ailment.id+"' data-cohort = '"+ailment.age_group_id+"' data-ailment = '"+ailment.ailment+"' data-description = '"+ailment.description+"'>Edit</a>";
					if (ailment.advice == null && ailment.treatment == null) {
						table_row += "&nbsp;<a data-id = '"+ailment.id+"' href = '#' class = 'btn btn-xs btn-danger delete-ailment'>Delete</a>";
					}
					table_row += "</td>";
					table_row += "</tr>";
					counter++;
				});
				$('#cohorts-table').html(table_row);
			},
			error: function(){
				toastr.error("There was an error fetching ailments");
			}
		})
		.done(function(){
			initAddAilment();
			table.parent().unblock();
		});
	}
</script>
@stop