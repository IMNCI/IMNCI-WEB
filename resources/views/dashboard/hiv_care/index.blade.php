@extends('layouts.dashboard')

@section('title', 'HIV Care for Children')

@section('action_area')
<!-- <a class="btn btn-sm btn-primary add-hiv-care" data-toggle="modal" data-target="#myModal5">Add HIV Care</a> -->

@endsection

@section('content')
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			You have some errors in your upload                            
			<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
			</ul>
        </div>
    @endif
    <div class="row">

    	<div class="col-md-5">
    		<div class="ibox">
    			<div class="ibox-content">
    				<button class="btn btn-sm btn-success pull-right" id = 'add-hiv-care'>Add HIV Care</button>
    				<br/>
    				@if(count($hivcare))
    				<ul class="sortable-list connectList agile-list" id="todo">
    					@if($parents)
	    					@foreach($parents as $parent)
	    					<h3>{{ $parent->parent }}</h3>
	    						@foreach($hivcare as $care)
	    							@if($care->parent == $parent->parent)
	    							<li class="care-link" style="">
	    								<input type="hidden" class="care_id" value="{{ $care->id }}">
	    								<span>{{ $care->title }}</span>
	    								<div class="agile-detail">
											<span class="pull-right">
												<a class="btn btn-xs btn-white edit-care" data-id = "{{ $care->id }}" data-title = "{{ $care->title }}" data-care = '{{ $care->content }}' data-parent = "{{ $care->parent }}">View/Edit</a>&nbsp;
												<a class="btn btn-xs btn-white remove-care" data-id = "{{ $care->id }}" data-title = "{{ $care->title }}" data-care = '{{ $care->content }}' data-parent = "{{ $care->parent }}">Remove</a>
											</span>
											@if ($care->parent)
											{{ $care->parent }}
											@else
											<br/>
											@endif
										</div>
	    							</li>
	    							@endif
	    						@endforeach
	    					@endforeach
    					@endif
    				</ul>
    				@else
    				@endif
    			</div>
    		</div>
    	</div>
    	<div class="col-md-7">
    		<div class="ibox">
    			<div class="ibox-content">
    				{!! Form::open(['url' => route('hiv_care_submit')]) !!}
    					{{ csrf_field() }}
    					{!! Form::hidden('id', 0) !!}
    					<div class="form-group">
    						{!! Form::label('title', 'Title', ['class'=>'control-label']) !!}
    						{!! Form::text('title', NULL, ['class' => 'form-control']) !!}
    					</div>
    					<div class="form-group">
    						{!! Form::label('parent', 'Parent', ['class'=>'control-label']) !!}
    						{!! Form::text('parent', NULL, ['class' => 'form-control', 'autocomplete'	=>	'off']) !!}
    					</div>
    					<div class="form-group">
    						{!! Form::label('content', 'Content', ['class'=>'control-label']) !!}
    						{!! Form::textarea('content', NULL, ['class' => 'form-control']) !!}
    					</div>

    					<a href="#" class="btn btn-success btn-block" id="save-changes">Save Changes</a>
    					<a class = "btn btn-danger btn-block" id="delete-data">Yes, Delete this data</a>
    					<button class="btn btn-primary btn-block" id="submit-data">Submit data</button>
    				{!! Form::close() !!}
    			</div>
    		</div>
    	</div>
    	<!-- <div class="col-md-5">
    		<div class="ibox">
    			<div class="ibox-title">
    				HIV Care Parents

    				<a class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#add-parent-modal" data-parent-name = '' data-parent-id = '0'>Add Parent</a>
    			</div>
    			<div class="ibox-content">
    				<table class="table table-striped">
    					<thead>
    						<th style="width: 70%">Parent</th>
    						<th>Actions</th>
    					</thead>
						<tbody>
							@forelse($parents as $parent)
							<tr>
								<td>{{ $parent->parent_name }}</td>
								<td>
									<div class="btn-group">
										<a class="btn btn-primary btn-sm view-hiv-care" type="button"><i class = 'fa fa-eye'></i></a>
										<a class="btn btn-success btn-sm edit-parent" type="button" data-toggle="modal" data-target="#add-parent-modal" data-parent-name = '{{ $parent->parent_name }}' data-parent-id = '{{ $parent->id }}'><i class = 'fa fa-pencil'></i></a>
										<a class="btn btn-danger btn-sm delete-parent" type="button"><i class = 'fa fa-trash'></i></a>
									</div>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="2"><center>There are no parents to display</center></td>
							</tr>
							@endforelse
						</tbody>
    				</table>
    			</div>
    		</div>
    	</div>
    	<div class="col-md-7">
    		@if(count($hivcare))
			<div class="ibox">
				<div class="ibox-content">
					<table class="table table-bordered table-hover">
						<th></th>
						<th>Title</th>
						<th>Parent</th>
						<th>Actions</th>
						@foreach($hivcare as $k => $care)
						<tr>
							<td style="width: 20%;">
								<img class="img-responsive" src="/storage/{{ $care->image_path }}">
							</td>
							<td style="vertical-align: middle;">{{ $care->title }}</td>
							
							<td>
								@if($care->parent_id != 0)
								{{ $care->parent->parent_name }}</td>
								@else
								No Parent Assigned
								@endif
							<td style="vertical-align: middle;">
								<a href = "#" class="btn btn-sm btn-white btn-block edit-hiv-care" data-id = "{{ $care->id }}" data-title = "{{ $care->title }}" data-image = "/storage/{{ $care->image_path }}" data-parent-id = '{{ $care->parent_id }}'  data-toggle="modal" data-target="#myModal5">Edit</a>
								<a href = "#" class="btn btn-sm btn-danger btn-block remove-hiv-care" data-id = "{{ $care->id }}" data-title = "{{ $care->title }}" data-image = "/storage/{{ $care->image_path }}" data-parent = '@if($care->parent_id != 0) {{ $care->parent->parent_name }} @endif' data-toggle="modal" data-target="#removeModal">Remove</a>
							</td>
						</tr>
						
						@endforeach
					</table>
				</div>
			</div>
	    	@else
	    	<div class="text-center p-xl">
				<i class="fa fa-exclamation-triangle fa-5x"></i>
				<h3>There are no HIV Care uploads just yet</h3>
				<a class="btn btn-sm btn-primary add-hiv-care" data-toggle="modal" data-target="#myModal5">Add the First One</a>
			</div>
	    	@endif
    	</div> -->
	</div>

	<div class="modal inmodal fade" id="add-parent-modal" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Add Parent</h4>
				</div>
				<div class="modal-body">
					<form method="POST" action="{{ route('hiv_care_submit_parent') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<input type="hidden" name="id">
						<div class="form-group">
							<label class="control-label">Parent Name</label>
							<input type="text" name="name" class="form-control parent_name" required />
						</div>
						
						<input name = 'parent_id' class = 'parent_id' type="hidden" />
				</div>

				<div class="modal-footer">
					<a type="button" class="btn btn-white" data-dismiss="modal">Close</a>
					<button type="submit" class="btn btn-primary">Save changes</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Add HIV Care</h4>
				</div>
				<div class="modal-body">
					<form method="POST" action="{{ route('hiv_care_submit') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<input type="hidden" name="id">
						<div class="form-group">
							<label class="control-label">Title</label>
							<input type="text" name="title" class="form-control" required />
						</div>

						<div class = 'form-group'>
							<label for="" class="control-label">Select a Parent</label>
							{!! Form::Select('parent_id', [0 => 'Please select a parent'] + (array)App\HIVCareParent::pluck('parent_name', 'id')->all(), null, ['class'=>'form-control']) !!}
						</div>

						<div class="form-group">
							<label class="control-label">Screenshot</label>
							<input type="hidden" name="thumb">
							<div class="fileinput fileinput-new input-group" data-provides="fileinput">
								<div class="form-control" data-trigger="fileinput">
									<i class="glyphicon glyphicon-file fileinput-exists"></i>
									<span class="fileinput-filename"></span>
								</div>
								<span class="input-group-addon btn btn-default btn-file">
									<span class="fileinput-new">Select file</span>
									<span class="fileinput-exists">Change</span>
									<input type="file" name="hiv_care_screenshot"/>
								</span>
								<a id="remove-screenshot-from-file" href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
							</div>

							<img class="img-responsive" id="screenshot-preview" src="" alt="Preview Appears here">
						</div>
						
				</div>

				<div class="modal-footer">
				<a type="button" class="btn btn-white" data-dismiss="modal">Close</a>
				<button type="submit" class="btn btn-primary">Save changes</button>
				</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal inmodal fade" id="removeModal" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Delete HIV Care</h4>
					<small class="font-bold">Are you sure you want to delete this entry? This action cannot be undone.</small>
				</div>
				<div class="modal-body">
					<form method="POST" action="{{ route('hiv_care_destroy') }}">
						{{ csrf_field() }}
						<input type="hidden" name="id">
						<div class="form-group">
							<label class="control-label">Title</label>
							<input id="hiv-care-title" type="text" class="form-control" disabled />
						</div>

						<div class="form-group">
							<label class="control-label">Parent</label>
							<input id="hiv-care-parent" type="text" class="form-control" disabled />
						</div>

						<div class="form-group">
							<label class="control-label">Screenshot</label>
							<img class="img-responsive" id="screenshot-preview" src="" alt="Preview Appears here">
						</div>
					
				</div>

				<div class="modal-footer">
				<a type="button" class="btn btn-white" data-dismiss="modal">Cancel</a>
				<button type="submit" class="btn btn-danger">Yes, Delete this Entry</button>
				</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/jasny/jasny-bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote-bs3.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/sweetalert/sweetalert.css') }}">
<style type="text/css">
	.hidden{
		display: none;
	}
</style>
@endsection

@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/typehead/bloodhound.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/summernote/summernote.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script type="text/javascript">

	var content_summernote;
	var emptyText = "<p></p><p></p>";

	$('#delete-data').addClass('hidden');
	$('#submit-data').addClass('hidden');

	$(document).ready(function(){
		content_summernote = $('textarea[name="content"]').summernote({
			height: "250px",
			placeholder: "Type here..."
		});

		$.get('/api/hiv/parents', function(res){
			$('input[name="parent"]').typeahead({ source:res });
		});

		$('.care-link').on('click', function(){
			var care_id = $(this).find('.care_id').val();
			showManageCare();

			$('input[name="title"]').val($(this).find('.edit-care').attr('data-title'));
			$('input[name="parent"]').val($(this).find('.edit-care').attr('data-parent'));
			content_summernote.summernote('code', $(this).find('.edit-care').attr('data-care'));
			$('input[name="id"]').val($(this).find('.edit-care').attr('data-id'));
		});

		$('#add-hiv-care').click(function(){
			showManageCare();

			$('input[name="title"]').val("");
			$('input[name="parent"]').val("");
			content_summernote.summernote('code', "");
			$('input[name="id"]').val(0);
		});

		$('.edit-care').on('click', function(e){
			showManageCare();

			$('input[name="title"]').val($(this).attr('data-title'));
			$('input[name="parent"]').val($(this).attr('data-parent'));
			content_summernote.summernote('code', $(this).attr('data-care'));
			$('input[name="id"]').val($(this).attr('data-id'));

			e.stopPropagation();
		});

		$('.remove-care').on('click', function(e){
			showManageCare("remove");

			$('input[name="title"]').val($(this).attr('data-title'));
			$('input[name="parent"]').val($(this).attr('data-parent'));
			content_summernote.summernote('code', $(this).attr('data-care'));
			$('input[name="id"]').val($(this).attr('data-id'));

			e.stopPropagation();
		});

		$('#save-changes').click(function(){
			toastr.warning("Please validate the data before submitting");
			$(this).addClass('hidden');
			$('#submit-data').removeClass('hidden');
		});

		$('#delete-data').click(function(){
			var id = $('input[name="id"]').val();
			swal({
				'title': 'Warning',
				'text': 'Once deleted, please note that this cannot be undone',
				'type' : 'warning',
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete it!"
			}, function(){
				window.location = '/hiv-care/delete/' + id;
			});
		});
	});

	function showManageCare(type){
		if (typeof(type) == "undefined") {
			$('#delete-data').addClass('hidden');
			$('#submit-data').addClass('hidden');
			$('#save-changes').removeClass('hidden');
		}else{
			$('#delete-data').removeClass('hidden');
			$('#submit-data').addClass('hidden');
			$('#save-changes').addClass('hidden');
		}
	}


	$('.edit-hiv-care').click(function(){
		var id = $(this).attr('data-id');
		var title = $(this).attr('data-title');
		var image_path = $(this).attr('data-image');
		var parent_id = $(this).attr('data-parent-id');

		manageAddEditModal(id, title, image_path, parent_id);
	});

	$('.remove-hiv-care').click(function(){
		var id = $(this).attr('data-id');
		var title = $(this).attr('data-title');
		var image_path = $(this).attr('data-image');
		var parent = $(this).attr('data-parent');

		$('#removeModal input[name="id"]').val(id);
		$('#removeModal #hiv-care-title').val(title);
		$('#removeModal #hiv-care-parent').val(parent);
		$('#removeModal #screenshot-preview').attr('src', image_path);

	});

	$('.add-hiv-care').click(function(){
		manageAddEditModal();
	});

	function manageAddEditModal(id, title, image_path, parent_id){
		if (typeof(id) != "undefined" && typeof(title) != "undefined" && typeof(image_path) != "undefined" && typeof(parent_id) != "undefined") {
			$('#myModal5 .modal-title').text('Edit HIV Care');
			$('#myModal5 input[name="title"]').val(title);
			$('#myModal5 input[name="id"]').val(id);
			$('#myModal5 select[name="parent_id"]').val(parent_id);
			// $('#myModal5 input[name="hiv_care_screenshot"]').val(image_path);
			$('#myModal5 #screenshot-preview').attr('src', image_path);
		}else{
			$('#myModal5 .modal-title').text('Add HIV Care');
			$('#myModal5 input[name="title"]').val("");
			$('#myModal5 input[name="id"]').val(0);
			$('#myModal5 select[name="parent_id"]').val(0);
			// $('#myModal5 input[name="hiv_care_screenshot"]').val("");
		}
	}
	$('input[name="hiv_care_screenshot"]').change(function(){
		readURL(this);
	});

	function readURL(input) {
		var ValidImageTypes = ["image/bmp", "image/jpeg", "image/png"];
		if (input.files && input.files[0]) {
			var fileType = input.files[0]["type"];
			if ($.inArray(fileType, ValidImageTypes) < 0) {
				toastr.error("The file type you are trying to upload is not allowed");
				$('#remove-screenshot-from-file').trigger('click');
			}else{
				var reader = new FileReader();
				reader.onload = function(e) {
					console.log(e);
					$('#screenshot-preview').attr('src', e.target.result);
					$('input[name="thumb"]').val(e.target.result);
				}

				reader.readAsDataURL(input.files[0]);
			}
		}else{
			$('#screenshot-preview').attr('src', "#");
			$('input[name="thumb"]').val("");
		}
	}

	$('#add-parent-modal').on('show.bs.modal', function(event){
		var button = $(event.relatedTarget);

		var parent_name = button.data('parent-name');
		var parent_id = button.data('parent-id');

		var modal = $(this);

		modal.find('.parent_name').val(parent_name);
		modal.find('.parent_id').val(parent_id);
	});
	
</script>

@if (session('status'))
<script type="text/javascript">
	toastr.success("{{ session('status') }}","Success");
</script>
@endif
@endsection