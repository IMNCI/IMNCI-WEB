@extends('layouts.dashboard')

@section('title', 'HIV Care for Children')

@section('action_area')
<a class="btn btn-sm btn-primary add-hiv-care" data-toggle="modal" data-target="#myModal5">Add HIV Care</a>

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
    	<div class="col-md-6">
    		<div class="ibox">
    			<div class="ibox-title">
    				HIV Care Parents
    			</div>
    		</div>
    	</div>
    	<div class="col-md-6">
    		
    	</div>
    	@if(count($hivcare))
    	<div class="ibox">
			<div class="ibox-content">
				<table class="table table-bordered table-hover">
					<th></th>
					<th>Title</th>
					<th>Actions</th>
					@foreach($hivcare as $k => $care)
					<tr>
						<td style="width: 20%;">
							<img class="img-responsive" src="/storage/{{ $care->image_path }}">
						</td>
						<td style="vertical-align: middle;">{{ $care->title }}</td>
						<td style="vertical-align: middle;">
							<a href = "#" class="btn btn-sm btn-white btn-block edit-hiv-care" data-id = "{{ $care->id }}" data-title = "{{ $care->title }}" data-image = "/storage/{{ $care->image_path }}"  data-toggle="modal" data-target="#myModal5">Edit</a>
							<a href = "#" class="btn btn-sm btn-danger btn-block remove-hiv-care" data-id = "{{ $care->id }}" data-title = "{{ $care->title }}" data-image = "/storage/{{ $care->image_path }}" data-toggle="modal" data-target="#removeModal">Remove</a>
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
@endsection

@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
<script type="text/javascript">
	$('.edit-hiv-care').click(function(){
		var id = $(this).attr('data-id');
		var title = $(this).attr('data-title');
		var image_path = $(this).attr('data-image');

		manageAddEditModal(id, title, image_path);
	});

	$('.remove-hiv-care').click(function(){
		var id = $(this).attr('data-id');
		var title = $(this).attr('data-title');
		var image_path = $(this).attr('data-image');

		$('#removeModal input[name="id"]').val(id);
		$('#removeModal #hiv-care-title').val(title);
		$('#removeModal #screenshot-preview').attr('src', image_path);

	});

	$('.add-hiv-care').click(function(){
		manageAddEditModal();
	});

	function manageAddEditModal(id, title, image_path){
		if (typeof(id) != "undefined" && typeof(title) != "undefined" && typeof(image_path) != "undefined") {
			$('#myModal5 .modal-title').text('Edit HIV Care');
			$('#myModal5 input[name="title"]').val(title);
			$('#myModal5 input[name="id"]').val(id);
			// $('#myModal5 input[name="hiv_care_screenshot"]').val(image_path);
			$('#myModal5 #screenshot-preview').attr('src', image_path);
		}else{
			$('#myModal5 .modal-title').text('Add HIV Care');
			$('#myModal5 input[name="title"]').val("");
			$('#myModal5 input[name="id"]').val(0);
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
	
</script>

@if (session('status'))
<script type="text/javascript">
	toastr.success("{{ session('status') }}","Success");
</script>
@endif
@endsection