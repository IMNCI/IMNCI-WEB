@extends('layouts.dashboard')

@section('title', 'Glossary')

@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="ibox">
			<div class="ibox-title">
				<a class="btn btn-primary btn-xs pull-right" id="add-glossary">New Glossary Item</a>
			</div>
			<div class="ibox-content">
				<table class="table table-striped" id="glossary-table">
					<thead>
						<tr>
							<th>#</th>
							<th>Acronym</th>
							<th>Description</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($glossary)
							<?php $counter = 1;?>
							@foreach($glossary as $item)
							<tr>
								<td>{{ $counter }}</td>
								<td>{{ $item->acronym }}</td>
								<td>{{ $item->description }}</td>
								<td>
									<a class="btn btn-block btn-xs btn-default edit-glossary" data-id = "{{ $item->id }}" data-acronym="{{ $item->acronym }}" data-description = "{{ $item->description }}">Edit</a>
									<a class="btn btn-block btn-xs btn-danger remove-glossary" data-id = "{{ $item->id }}">Delete</a>
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
	<div class="col-md-4">
		<div class="ibox">
			<div class="ibox-title">
				<h5>New Glossary</h5>
			</div>
			<div class="ibox-content">
				<form id="manage-glossary">
					<input type="hidden" name="id" value="0" />
					<div class="form-group">
						<label class="control-label">Acronym</label>
						<input class="form-control" name = "acronym" required />
					</div>

					<div class="form-group">
						<label class="control-label">Description</label>
						<textarea class="form-control" name = "description" rows="5" required></textarea>
					</div>

					<button class="btn btn-sm btn-block btn-success">Save Glossary Item</button>
				</form>
			</div>
		</div>
	</div>
</div>
@stop

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/sweetalert/sweetalert.css') }}">
@stop

@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/dataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#glossary-table').dataTable();
	});

	$('#manage-glossary').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url: "/api/glossary",
			method: "POST",
			data: $('#manage-glossary').serialize(),
			beforeSend: function(){
				$('#manage-glossary').block();
			},
			success: function(){
				toastr.success("Successfully saved glossary item");
				// if ($('input[name="id"]').val() == 0) {
					location.reload();
				// }
			},
			error: function(){
				$('#manage-glossary').unblock();
				toastr.error("There was an error saving item");
			}
		})
		.done(function(){
			$('#manage-glossary').unblock();
		});
	});

	$('#add-glossary').on('click', function(){
		initAddGlossary();
	});

	$('.edit-glossary').on('click', function(){
		$('.ibox-title h5').text("Editing Glossary");
		$('#manage-glossary input[name="id"]').val($(this).attr('data-id'));
		$('#manage-glossary input[name="acronym"]').val($(this).attr('data-acronym'));
		$('#manage-glossary textarea[name="description"]').val($(this).attr('data-description'));
	});

	$('.remove-glossary').on('click', function(){
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
				url: '/api/glossary/' + id,
				method: "DELETE",
				success: function(res){
					if (res.status == true) {
						swal("Success", "Successfully deleted glossary item", "success");
						location.reload();
					}else{
						swal("Error", res.message, "error");
					}
				},
				error: function(){
					swal("Error", "There was an error deleting this glossary item", "error");
				}
			});
		});
	});

	function initAddGlossary(){
		$('.ibox-title h5').text("New Glossary");
		$('#manage-glossary input[name="id"]').val(0);
		$('#manage-glossary input[name="acronym"]').val("");
		$('#manage-glossary textarea[name="description"]').val("");
	}
</script>
@stop