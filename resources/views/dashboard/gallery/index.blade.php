<?php
use App\GalleryItem;
use App\GalleryAilment;
?>
@extends('layouts.dashboard')
@section('title', "Gallery")
@if(isset($ailment_id))
@section('subtitle', "&nbsp;:&nbsp;&nbsp;" . $ailment->ailment)
@else
<?php $ailment_id = 0; ?>
@endif
@section('action_area')
<a class="btn btn-primary btn-sm" href="/gallery-ailments">Manage Ailments</a>
@stop

@section('content')
@if (count($errors) > 0)
<div class="alert alert-danger alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<p>You have some errors to handle:</p>
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>	
    {{ $message }} <a class="alert-link" href="{{ Session::get('url') }}" target="_blank">View File</a>
</div>
@endif
<div id="list-gallery">
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>Pick an Ailment</label>
				<select class="form-control" id="ailment-select">
					<option value="">All</option>
					<?php $selected = ""; ?>
					@foreach($ailments as $ailment)
					@if(isset($ailment_id) && $ailment_id == $ailment->id)
						<?php $selected = "selected = 'selected'"; ?>
					@else
						<?php $selected = ""; ?>
					@endif
					<option value="{{ $ailment->id }}" {{ $selected }}>{{ $ailment->ailment }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-md-3 pull-right">
			<a id="add-title" class="btn btn-primary btn-sm pull-right" href="#" data-toggle="modal" data-target="#add-gallery-modal">Add Gallery Item</a>

			<!-- Modals -->
			<!-- Add Gallery Modal -->
			<div id="add-gallery-modal" class="modal fade" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Add Gallery Item</h4>
						</div>
						<div class="modal-body">
							{{ Form::open(['url' => 'add-gallery', 'files'	=>	true]) }}
								<div class="form-group">
									{{ Form::label('gallery_items_id', "Section") }}
									{{ Form::select('gallery_items_id', GalleryItem::pluck('item', 'id'), null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group">
									{{ Form::label('gallery_ailments_id', "Ailment") }}
									{{ Form::select('gallery_ailments_id', GalleryAilment::pluck('ailment', 'id'), $ailment_id, ['class'=>'form-control']) }}
								</div>

								<div class="form-group">
									{{ Form::label('title', "Title") }}
									{{ Form::text('title', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group">
									{{ Form::label('description', "Description") }}
									{{ Form::textarea('description', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group">
									{{ Form::label('file', "Upload File") }}
									<div class="fileinput fileinput-new input-group" data-provides="fileinput">
										<div class="form-control" data-trigger="fileinput">
											<i class="glyphicon glyphicon-file fileinput-exists"></i>
											<span class="fileinput-filename"></span>
										</div>
										<span class="input-group-addon btn btn-default btn-file">
											<span class="fileinput-new">Select file</span>
											<span class="fileinput-exists">Change</span>
											{{ Form::file('file') }}
										</span>
										<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
									</div>

									<p id="size" class="hidden"><span><b>File Size: </b></span><span id="fileSize"></span></p>
								</div>
						</div>
						<div class="modal-footer">							
							<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Save</button>
							{{ Form::close() }}
						</div>
					</div>

				</div>
			</div>

			<!-- View Details Modal -->
			<div id="view-gallery-modal" class="modal fade" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">View Gallery Item</h4>
						</div>
						<div class="modal-body">
							<div id="gallery-details"></div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-danger hidden" id="delete-gallery">Yes, Proceed with Delete</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="tabs-container">
				<ul class="nav nav-tabs">
					<?php $class = "active"; ?>
					@foreach($galleryitems as $item)
					<li class="{{ $class }}"><a data-toggle = "tab" href = "#tab-{{ $item->id }}">{{ $item->item }}&nbsp;&nbsp;&nbsp;<div class="pull-right"><span class="badge badge-primary">{{ count($gallery[$item->id]) }}</span></div></a></li>
					<?php $class = ""; ?>
					@endforeach
				</ul>

				<div class="tab-content">
					<?php $class = "active"; ?>
					@foreach($galleryitems as $item)
					<div id="tab-{{ $item->id }}" class="tab-pane {{ $class }}">
						<div class="panel-body">
							<!-- <div class="table-responsive"> -->
								<table class="table table-striped">
									<thead>
										<th></th>
										<th style="width: 30%;">Title</th>
										<th>File Type</th>
										<th>Ailment</th>
										<th>File Size (Bytes)</th>
										<!-- <th>Date Uploaded</th> -->
										<th>Last Modified</th>
										<th>Actions</th>
									</thead>
									<tbody>
										@forelse($gallery[$item->id] as $g)
										<tr>
											<td>
												@if($g->type == "PDF")
												<?php $icon = "fa fa-file-pdf-o"; ?>
												@elseif($g->type == "Word Document")
												<?php $icon = "fa fa-file-word-o"; ?>
												@elseif($g->type == "Spreadsheet")
												<?php $icon = "fa fa-file-excel-o"; ?>
												@elseif($g->type == "Presentation")
												<?php $icon = "fa fa-file-powerpoint-o"; ?>
												@else
												<?php $icon = "fa fa-file-image-o"; ?>
												@endif
												<i class = "{{ $icon }}"></i>
											</td>
											<td>{{ $g->title }}</td>
											<td>{{ $g->type }}</td>
											<td>{{ $g->ailment->ailment }}</td>
											<td>{{ $g->size }}</td>
											<td>{{ $g->created_at }}</td>
											<!-- <td>
												@if($g->created_at == $g->updated_at)
												<span class="label label-warning">Never updated</span>
												@else
												{{ $g->updated_at }}
												@endif
											</td> -->
											<td>
												<div class="btn-group">
													<button data-toggle = "dropdown" class="btn btn-white btn-xs dropdown-toggle">
														Action
														<span class="caret"></span>
													</button>
													<ul class="dropdown-menu">
														<li>
															<a href="{{ route('getFile', $g->id) }}" target="_blank" download><i class="fa fa-download"></i>&nbsp;Download File</a>
														</li>
														<li><a href="#" class="view-details" data-id = "{{ $g->id }}"><i class="fa fa-eye"></i>&nbsp;View Details</a></li>
														<li><a href="#"><i class="fa fa-edit"></i>&nbsp;Edit Upload</a></li>
														<li><a href="#" class="remove-gallery" data-id = "{{ $g->id }}"><i class="fa fa-trash-o"></i>&nbsp;Delete Upload</a></li>
													</ul>
												</div>
											</td>
										</tr>
										@empty
										<tr>
											<td colspan="7"><center>No data available for {{ $item->item }}</center></td>
										</tr>
										@endforelse
									</tbody>
								</table>
							<!-- </div> -->
						</div>
					</div>
					<?php $class = ""; ?>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>

@stop

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/jasny/jasny-bootstrap.min.css') }}">
@endsection

@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
<script type="text/javascript">
	$('#ailment-select').on('change', function(){
		if ($(this).val() != "") {
			window.location = "{{ route('gallery') }}/" + $(this).val();
		}else{
			window.location = "{{ route('gallery') }}";
		}
	});

	$('input[name="file"]').on('change', function(){
		galleryRead(this);
	});

	$('.view-details').on('click', function(){
		var id = $(this).attr('data-id');
		$('#view-gallery-modal .modal-title').text("View Gallery Item");
		$('#delete-gallery').addClass("hidden");
		$.when(getGalleryPage(id));
		$('#delete-gallery').removeAttr('data-id');
	});

	$('.remove-gallery').on('click', function(){
		var id = $(this).attr('data-id');
		$('#delete-gallery').attr('data-id', id);
		$('#view-gallery-modal .modal-title').text("Delete Gallery Item");
		$('#delete-gallery').removeClass("hidden");
		$.when(getGalleryPage(id));
	});

	$('#delete-gallery').on('click', function(){
		var id = $(this).attr('data-id');

		if (id) {
			$.ajax({
				'url'		:	'/api/gallery/delete/' + id,
				'method'	:	'DELETE',
				'data'		:	{
					'id'	:	id
				},
				beforeSend	:	function(){
					$('#view-gallery-modal').block({
						message: "<img style = 'width: 50px;' src = '{{ asset('Blocks.gif') }}' />",
						css: { 
				            border: 'none', 
				            padding: '15px', 
				            backgroundColor: 'none', 
				            '-webkit-border-radius': '10px', 
				            '-moz-border-radius': '10px', 
				            color: '#fff' 
				        }
					});
				},
				success 	:	function(){
					toastr.success("Succesfully deleted item");
					$('#view-gallery-modal').unblock();
					location.reload();
				},
				error 		: 	function(){
					toastr.error("There was an error deleting this item");
					$('#view-gallery-modal').unblock();
				}
			});
		}
	});

	function getGalleryPage(gallery_item_id){
		$('#wrapper').block({
			message: "<img style = 'width: 50px;' src = '{{ asset('Blocks.gif') }}' />",
			css: { 
	            border: 'none', 
	            padding: '15px', 
	            backgroundColor: 'none', 
	            '-webkit-border-radius': '10px', 
	            '-moz-border-radius': '10px', 
	            color: '#fff' 
	        }
		});
		$.get('/api/gallery/view/' + gallery_item_id).promise().done(function(res){
			$('#wrapper').unblock();
			$('#gallery-details').html(res);
			$('#view-gallery-modal').modal();
		});
	}

	function galleryRead(input) {
		var ValidImageTypes = ["image/bmp", "image/jpeg", "image/png", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/msword", "application/pdf"];
		if (input.files && input.files[0]) {
			$('#size').removeClass('hidden');
			var fileType = input.files[0]["type"];
			var fileSize = input.files[0]["size"];
			$('#fileSize').text(Math.round(fileSize / 1024) + " KB");
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
			$('#size').addClass('hidden');
			$('#screenshot-preview').attr('src', "#");
			$('input[name="thumb"]').val("");
		}
	}
</script>
@endsection