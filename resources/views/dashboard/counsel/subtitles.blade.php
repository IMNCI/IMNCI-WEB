@extends('layouts.dashboard')

@section('title', "Counsel the Mother Sub Content: ")
@section('subtitle', $title->title)

@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="/counsel-the-mother">Counsel the Mother Titles</a></li>
	<li class="active">Sub Content</li>
</ol>
@stop

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote-bs3.css') }}">
@stop

@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/summernote/summernote.min.js') }}"></script>

<script type="text/javascript">
	var content_summernote;
	$(document).ready(function(){
		content_summernote = $('textarea[name="content"]').summernote({
			height: "250px",
			placeholder: "Type here..."
		});
	});

	$('#add-sub-title, .edit-sub-title, .remove-sub-content').click(function(){
		manageAddEditUI(this);
	});

	$('.close-btn').click(function(){
		$('#title-form-wrapper').removeClass("bounceInRight");
		$('#title-form-wrapper').addClass("bounceOutRight");
	});


	$('#save-title').on('click', function(event){
		event.preventDefault();
		var title = $('input[name="sub_content_title"]').val();
		var content = $('textarea[name="content"]').val();

		if (title != "" && content != "") {
			toastr.warning("Please review content before submiting it");
			$(this).addClass('hidden');
			$('#submit-title').removeClass('hidden');
		}else{
			toastr.error("Both the title and the cohorts have to be filled");
		}
	});

	$('#submit-title').click(function(e){
		e.preventDefault();
		$.ajax({
			url: $('#title-form-wrapper form').attr('action'),
			method: $('#title-form-wrapper form').attr('method'),
			data: $('#title-form-wrapper form').serialize(),
			beforeSend: function(){
				$('#title-form-wrapper').block({
					message: ""
				});
			},
			success: function(){
				toastr.success("Successfully saved sub content");
				location.reload();
			},
			error: function(){
				$('#title-form-wrapper').unblock();
				toastr.error("There was an error saving sub content");
			}
		});
	});

	$('#confirm-remove-title').click(function(e){
		e.preventDefault();
		$.ajax({
			url: $('#title-form-wrapper form').attr('action'),
			method: 'DELETE',
			data: $('#title-form-wrapper form').serialize(),
			beforeSend: function(){
				$('#title-form-wrapper').block({
					message: ""
				});
			},
			success: function(){
				toastr.success("Successfully deleted sub content");
				location.reload();
			},
			error: function(){
				$('#title-form-wrapper').unblock();
				toastr.error("There was an error saving sub content");
			}
		});
	});


	manageAddEditUI = function(that){
		var title = "";

		if($(that).hasClass('remove-sub-content')){
			title = "Delete Sub Content";
			$('#confirm-remove-title').removeClass('hidden');
			$('#submit-title, #save-title').addClass('hidden');
		}else{
			$('#save-title').removeClass('hidden');
			$('#submit-title, #confirm-remove-title').addClass('hidden');
			if (typeof($(that).attr('data-id')) == "undefined") {
				title = "Add Sub Content";
			}else{
				title = "Edit Sub Content";
			}
		}


		if (typeof($(that).attr('data-id')) != "undefined") {
			$('#title-form-wrapper input[name="sub_content_id"]').val($(that).attr('data-id'));
			$('#title-form-wrapper input[name="sub_content_title"]').val($(that).attr('data-sub-content-title'));
			content_summernote.summernote("code", $(that).attr('data-content'));
		}else{
			$('#title-form-wrapper input[name="sub_content_id"]').val(0);
			$('#title-form-wrapper input[name="sub_content_title"]').val("");
			content_summernote.summernote("code", "");
		}

		$('#title-form-wrapper .ibox-title h5').text(title);
		$('#title-form-wrapper').addClass("bounceInRight");
		$('#title-form-wrapper').removeClass("bounceOutRight");
	}
</script>
@stop

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="ibox">
			<div class="ibox-title">
				<div class="pull-right">
					<a class="btn btn-primary btn-xs" id = "add-sub-title">Add Sub Content</a>
				</div>
			</div>		
			<div class="ibox-content">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Subtitle</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($title->subcontent as $subcontent)
						<tr>
							<td>{{ $subcontent->sub_content_title }}</td>
							<td>
								<a class="edit-sub-title btn btn-xs btn-block btn-white" data-id = "{{ $subcontent->id }}" data-sub-content-title = "{{ $subcontent->sub_content_title }}" data-content = "{{ $subcontent->content }}">Edit</a>
								<a class="remove-sub-content btn btn-xs btn-block btn-danger" data-id = "{{ $subcontent->id }}" data-sub-content-title = "{{ $subcontent->sub_content_title }}" data-content = "{{ $subcontent->content }}">Remove</a>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="2"><center>There are no sub contents for this</center></td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="ibox h-built animated bounceOutRight" id="title-form-wrapper">
			<div class="ibox-title">
				<h5>Add Sub Content</h5>

				<div class="pull-right">
					<a class="close-btn text-danger" title="Close this section"><i class = "fa fa-times"></i></a>
				</div>
			</div>		
			<div class="ibox-content">
				<form method="POST" action="/api/counsel-sub-content">
					<input type="hidden" name="counsel_titles_id" value="{{ $title->id }}">
					<input type="hidden" name="sub_content_id" value="0">
					<div class="form-group">
						<label class="control-label">Sub Content Title</label>
						<input class="form-control" name="sub_content_title" />
					</div>

					<div class="form-group">
						<label class="control-label">Content</label>
						<textarea class="form-control" name="content"></textarea>
					</div>

					<a class="btn btn-success btn-block" id="save-title">Save Sub Content</a>
					<button class="btn btn-primary btn-block hidden" id="submit-title">Submit this Sub Content</button>
					<a class="btn btn-danger btn-block hidden" id="confirm-remove-title">Yes, Remove this Sub Content</a>
				</form>
			</div>
		</div>
	</div>
@stop