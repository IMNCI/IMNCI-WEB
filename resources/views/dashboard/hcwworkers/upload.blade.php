@extends('layouts.dashboard')

@section('title', 'Upload HCW Workers')

@section('content')
@if($temp_count == 0)
<div class="row" id="fileupload-section">
	<div class="col-md-12">
		<div class="ibox">
			<div class="ibox-content">
				{!! Form::open(['url' => '/api/hcw/import', 'class' => 'dropzone', 'files'=>true, 'id'=>'dropzoneForm']) !!}
					<div class="fallback">
					<input name="hcwsheet" type="file" />
					</div>
					{!! Form::hidden('csrf-token', csrf_token(), ['id' => 'csrf-token']) !!}
				{!! Form::close() !!}
			</div>
		</div>
		
	</div>
</div>
@else
<div class="row">
	<div class="col-md-12">
		<div class="ibox" id="imported-hcw-wrapper">
			<div class="ibox-content">
				<table class="table table-bordered" id = "datatable">
					<thead>
						<th>Name</th>
						<th>Phone</th>
						<th>County</th>
					</thead>
					<tbody id="imported-hcw">
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endif
@endsection


@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dropzone/basic.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dropzone/dropzone.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/xeditable/bootstrap3-editable/css/bootstrap-editable.css') }}">

@endsection

@section('page_js')
@parent
<script src="{{ asset('dashboard/js/plugins/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('dashboard/js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('dashboard/js/plugins/dataTables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('dashboard/xeditable/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
<script type="text/javascript">
	var loader = '<div class="sk-spinner sk-spinner-pulse"></div>';
	$.fn.editable.defaults.mode = 'inline';

	var blockObj = {
		message: loader,
		css:  { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: 'none', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            color: '#fff' 
        }
	}
	Dropzone.options.dropzoneForm = {
		maxFiles: 1,
		accept: function(file, done) {
			$('#fileupload-section').block(blockObj);
			// toastr.success('File Uploaded Successfully');
			done();
		},
		complete: function(file, response){
			this.removeFile(file);
			$('#fileupload-section').hide();
		},
		init: function() {
			this.on("maxfilesexceeded", function(file){
				toastr.error("Maximum upload reached!");
			});

			this.on("success", function(file, response){
				drawTable(response);
			});
		}
	}

	function drawTable(hcw_workers){
		$('#datatable').dataTable({
			iDisplayLength: 20,
			data : hcw_workers,
			columns : [
				{data: "hcw_name", render: function(data){
					return '<span class = "editable" data-type = "text" data-url = "/api/hcw-temp/update" data-name = "hcw_name" data-title = "Enter HCW name">' + data + '</span>'; 
				}},
				{data: "mobile_number", render: function(data){
					return '<span class = "editable" data-type = "text" data-url = "/api/hcw-temp/update" data-name = "mobile_number" data-title = "Enter Mobile Number">' + data + '</span>';
				}},
				{data: "county", render: function(data){
					return '<span class = "county-editable" data-type = "select" data-url = "/api/hcw-temp/update" data-name = "county" data-title = "Pick a County">' + data + '</span>';
				}}
			],
			fnRowCallback: function(nRow, mData, iDisplayIndex){
				$('.editable', nRow).editable();

				var counties = "{{ $counties }}";
				$('.county-editable', nRow).editable({
					source: JSON.parse(counties.replace(/&quot;/g,'"'))
				});

				$('.editable', nRow).attr('data-pk', mData.id);
				$('.county-editable', nRow).attr('data-pk', mData.id);

				return nRow;
			}
		});
	}
	
	$(document).ready(function(){
		$('.editable').click(function(e) {
			e.stopPropagation();
			$(this).editable('toggle');
		});

		$.ajax({
			url: '/api/hcw-temp/all',
			method: 'GET',
			beforeSend: function(){
				$('#imported-hcw-wrapper').block(blockObj);
			},
			success: function(res){
				$('#imported-hcw-wrapper').unblock();
				drawTable(res);
			},
			error: function(){
				$('#imported-hcw-wrapper').unblock();
				drawTable([]);
			}
		});
	});
</script>
@endsection