@extends('layouts.dashboard')

@section('title', 'Assess, Classify & Identify Treatment: ')
@section('subtitle')
<b id="cohort-sub-title"></b>
@stop

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/toastr/toastr.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote-bs3.css') }}">
<style type="text/css">
	.modal-lg{
		width: 900px !important;
	}
</style>
@stop

@section('content')
	<div class="row">
		<div class="col-md-12" id="iform">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					
				</div>
				<div class="ibox-content">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Cohort</label>
								<select class="form-control" id = "age_group">
									<!-- <option value="0">Select an Age Group</option> -->
									@foreach ($age_groups as $group)
									<option value="{{ $group->id }}">{{ $group->age_group }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Section</label>
								<select class="form-control" id="section">
									<option value="0">All Sections</option>
									@foreach ($sections as $section)
									<option value="{{ $section->id }}">{{ $section->group }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">&nbsp;</label>
								<div class="">
									<a class="btn btn-primary btn-sm" id="get-data">Get Assessments</a>
									<a class="btn btn-success btn-sm" data-toggle = "modal" data-target = "#add-assessment-modal" id="add-assessment">Add Assessment</a>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered" id="assessment-table">
								<thead>
									<tr>
										<th>Section</th>
										<th style="width: 40%;">Assessment Title</th>
										<th>Content Available?</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody id="table-content">
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('modal')
	<div class="modal inmodal" id="add-assessment-modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
					<!-- <i class="fa fa-laptop modal-icon"></i> -->
					<h4 class="modal-title">Add Assessment</h4>
					<small class="font-bold">Create a new assessment</small>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label">Cohort</label>
						<!-- <input class="form-control" disabled="disabled" id="cohort" /> -->
						<select class="form-control" name = "age_group_id">
							@foreach ($age_groups as $group)
							<option value="{{ $group->id }}">{{ $group->age_group }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label class="control-label">Section</label>
						<!-- <input class="form-control" disabled="disabled" id="section" /> -->
						<select class="form-control" name="section_id">
							@foreach ($sections as $section)
							<option value="{{ $section->id }}">{{ $section->group }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label class="control-label">Assessment Title</label>
						<input class="form-control" name = "title" />
					</div>

					<input type="hidden" name="assessment_id" value="">

					<div class="form-group">
						<label class="control-label">Content</label>
						<textarea class="form-control" name = "assessment" rows="8"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id = "save-changes">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal inmodal" id="content-modal" tabindex="-1" role = "dialog" aria-hidden = "true" style="display: none;" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
					<!-- <i class="fa fa-laptop modal-icon"></i> -->
					<h4 class="modal-title">Confirm Assessment</h4>
					<small class="font-bold">Confirm that this is the assessment you want to delete</small>
				</div>
				<div class="modal-body">
					<input type="hidden" name="_assessment_id" value="0" />
					<div class="well well-sm">
						<h3>Cohort</h3>
						<span id="content-cohort"></span>
					</div>

					<div class="well well-sm">
						<h3>Section</h3>
						<span id="content-section"></span>
					</div>

					<div class="well well-sm">
						<h3>Title</h3>
						<span id="content-title"></span>
					</div>

					<div class="well well-sm">
						<h3>Content</h3>
						<span id="content-content"></span>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-danger" id = "continue">Remove this Assessment!</button>
				</div>
			</div>
		</div>
	</div>
@stop

@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/summernote/summernote.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/jquery.blockUI.js') }}"></script>
<script type="text/javascript">
	var blocking_message = "";
	toastr.options = {
		closeButton: true,
		progressBar: true,
		showMethod: 'slideDown',
		timeOut: 4000
	};

	$('#age_group').change(function(){
		$('#cohort-sub-title').text($('#age_group option:selected').text());
	});

	var assessment_text_area = $('textarea[name="assessment"]').summernote({
			height: "250px",
			placeholder: "Type here..."
		});

	var add_assessment_btn = $('#add-assessment');
	add_assessment_btn.hide();

	add_assessment_btn.click(function(e){
		e.preventDefault();
		if($('#section').val() == 0){
			e.stopPropagation();
			toastr.error("Cannot add assessment before picking a section");
		}
		initialiseModal();

		var age_group = $('#age_group').val();
		var section = $('#section').val();

		$('#add-assessment-modal select[name="age_group_id"]').val(age_group);
		$('#add-assessment-modal select[name="section_id"]').val(section);
	});

	var header_count = $('#assessment-table thead tr th').length;
	$(document).ready(function(){
		$('#get-data').trigger('click');
		$('#cohort-sub-title').text($('#age_group option:selected').text());
	});
	
	$('#get-data').click(function(){
		if($('#age_group').val() == 0){
			add_assessment_btn.hide();
			alert("Please pick both the age group and the section");
		}else{
			add_assessment_btn.show();
			$.ajax({
				url: "/api/get-assessments",
				type: "POST",
				data: {
					age_group: $('#age_group').val(),
					category: $('#section').val()
				},
				beforeSend: function(){
					$('#iform').block({
						message: blocking_message
					});
				},
				success: function(res){
					$('#iform').unblock();
					var table = $('#table-content');
					var table_content = "";
					if (res.length > 0) {
						$.each(res, function(key, value){
							var remove_button = "";
							table_content += "<tr>";
							table_content += "<td>"+value.group+"</td>";
							table_content += "<td>"+value.title+"</td>";
							table_content += "<td><center>";
							if (value.classifications > 0) {
								table_content += "<i class = 'fa fa-check text-info'></i>";
							}else{
								table_content += "<i class = 'fa fa-times text-danger'></i>";
								remove_button = "&nbsp;<a class = 'remove-assessment btn btn-danger btn-xs' data-id = '"+value.id+"'>Remove</a>";
							}
							table_content += "</center></td>";
							table_content += "<td>";
							table_content += "<a class = 'edit-assessment btn btn-xs btn-default' href = '#' data-id = '"+value.id+"' data-section_id = '"+value.category_id+"'>Edit Assessment</a>";
							table_content += "&nbsp;<a class = 'manage-classifications btn btn-xs btn-default' href = '/classifications/"+value.id+"' data-id = '"+value.id+"'>Manage Classifications</a>" + remove_button;
							// table_content += remove_button;
							table_content += "</td>";
							table_content += "</tr>";
						});
					}
					else{
						table_content = "<tr><td colspan = '"+header_count+"'><center>No Assessments Available</center></td></tr>";
					}

					table.html(table_content);
				},
				error: function(){
					$('#iform').unblock();
					toastr.error("There was an error fetching assessment data");
				}
			});
		}
	});

	$('#save-changes').click(function(){
		var age_group = $('select[name="age_group_id"]').val();
		var category_id = $('select[name="section_id"]').val();
		var title = $('input[name="title"]').val();
		var assessment = $('textarea[name="assessment"]').val();
		var assessment_id = $('input[name="assessment_id"]').val();

		submit_data = {
				age_group 	: age_group,
				section 	: category_id,
				title 		: title,
				assessment 	: assessment,
				id  		: assessment_id
			};

		$.ajax({
			url : "/api/assessment",
			type: "POST",
			data : submit_data,
			beforeSend: function(){
				$('body').block();
			},
			success: function(res){
				$('#get-data').trigger('click');
				$('body').unblock();
				initialiseModal();

				toastr.success("Successfully added assessment");
				$('#add-assessment-modal').modal('hide');
			},
			error: function(){
				$('body').unblock();
				toastr.error("There was an error adding assessment");
			}
		});
	});

	$('#assessment-table').on('click', 'a.edit-assessment', function(){
		$('#add-assessment-modal input#section').val($(this).closest('td').prev('td').text());
		var section = $(this).attr('data-section_id');
		$.get('/api/assessment/' + $(this).attr('data-id'), function(res){
			var age_group = $('#age_group').val();
			// var section = $(this).val();;
			$('#add-assessment-modal select[name="category_id"]').val(section);
			// $('#add-assessment-modal input#cohort').val($('#age_group option[value="'+age_group+'"]').text());
			$('#add-assessment-modal select[name="age_group_id"]').val(age_group);
			$('#add-assessment-modal').modal();
			$('#add-assessment-modal .modal-header').html('<h4 class="modal-title">Edit Assessment</h4><small class="font-bold">Editing the selected assessment</small>');
			$('#add-assessment-modal .modal-body input[name="title"]').val(res.title);
			assessment_text_area.summernote('code', res.assessment);
			$('input[name="assessment_id"]').val(res.id);
		});
	});

	$('#assessment-table').on('click', 'a.remove-assessment', function(){
		var id = $(this).attr('data-id');

		var age_groups = jQuery.parseJSON('<?= @$age_groups; ?>');
		var sections = jQuery.parseJSON('<?= @$sections; ?>');

		$.get('/api/assessment/' + id, function(res){
			var _age_group = _section = "";
			$.each(age_groups, function(key, value){
				if (value.id == res.age_group_id) {
					_age_group = value.age_group;
				}
			});

			$.each(sections, function(key, value){
				if (value.id == res.category_id) {
					_section = value.group;
				}
			});
			$('#content-modal input[name="_assessment_id"]').val(res.id);
			$('#content-cohort').text(_age_group);
			$('#content-section').text(_section);
			$('#content-title').text(res.title);
			$('#content-content').html(res.assessment);
			$('#content-modal').modal();
		});
	});

	$('#assessment-table').on('click', 'a.manage-classifications', function(){
		// window.location = "/classifications/" + $(this).attr('data-id');
	});

	$('#continue').on('click', function(){
		$.ajax({
			url: "/api/assessment/" + $('#content-modal input[name="_assessment_id"]').val(),
			method: "DELETE",
			beforeSend: function(){
				$('#modal-content .modal-content').block({
					message: ""
				});
			},
			success: function(){
				toastr.success("Successfully deleted assessment");
				location.reload();
			},
			error: function(){
				$('#modal-content').unblock();
				toastr.error("There was an error deleting the assessment");
			}
		});
	});

	function initialiseModal(){
		$('#add-assessment-modal .modal-header').html('<h4 class="modal-title">Add Assessment</h4><small class="font-bold">Create a new assessment</small>');
		$('#add-assessment-modal .modal-body input[name="title"]').val("");
		assessment_text_area.summernote('code', "");
		$('#assessment_id').val("");
	}

</script>
@stop