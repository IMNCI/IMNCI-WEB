@extends('layouts.dashboard')

@section('title', 'HCW Workers')

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dropzone/basic.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dropzone/dropzone.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/responsive.dataTables.min.css') }}">
@stop

@section('action_area')
<div class="btn-group">
    <button data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle"><i class = 'fa fa-cog'></i> <span class="caret"></span></button>
    <ul class="dropdown-menu">
        <li><a href="{{ route('hcw-send-test-sms') }}"><i class = 'fa fa-wrench'></i>&nbsp;&nbsp;Send Test SMS</a></li>
        <li><a href="{{ route('sms-log') }}"><i class = 'fa fa-table'></i>&nbsp;&nbsp;View SMS Log</a></li>
        <li><a href="{{ route('hcw-upload-data') }}"><i class = 'fa fa-upload'></i>&nbsp;&nbsp;Import Data</a></li>
    </ul>
</div>
<button id = "send-all" class = "btn btn-primary btn-sm" data-href = '{{ route("hcw-send-sms") }}'>Send Invitation SMS to All Workers</button>
@stop

@section('content')
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
{{ Session::get('success') }}
</div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="ibox">
			<div class="ibox-content">
                <table class="table table-bordered" id="hcw-workers">
                    <thead>
                        <th style = 'width: 65%;'>Name</th>
                        <th>Mobile</th>
                        <th>County</th>
                    </thead>
                    <tbody>
                        @forelse ($workers as $worker)
                            <tr>
                                <td>{{ $worker->hcw_name }}</td>
                                <td>{{ $worker->mobile_number }}</td>
                                <td>{{ $worker->county }}</td>
                            </tr>
                        @empty
                            <!-- <tr>
                                <td colspan = '3'><center>No HCW Workers found here</center></td>
                            </tr> -->
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('modal')
<div class="modal inmodal" id="uploadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-upload modal-icon"></i>
                <h4 class="modal-title">Upload HCW Worker List</h4>
                <small class="font-bold">Please note that the data will be appended to the existent one</small>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => '/api/hcw/import', 'class' => 'dropzone', 'files'=>true, 'id'=>'dropzoneForm']) !!}
                    <div class="fallback">
                        <input name="hcwsheet" type="file" />
                    </div>
                    {!! Form::hidden('csrf-token', csrf_token(), ['id' => 'csrf-token']) !!}
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('page_js')
@parent
<script src="{{ asset('dashboard/js/plugins/dropzone/dropzone.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('dashboard/js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('dashboard/js/plugins/dataTables/dataTables.responsive.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#hcw-workers').dataTable({
            "iDisplayLength": 25
        });
    });

    Dropzone.options.dropzoneForm = {
        maxFiles: 1,
        accept: function(file, done) {
            toastr.success('File Uploaded Successfully');
            done();
        },
        complete: function(file){
            this.removeFile(file);
        },
        init: function() {
            this.on("maxfilesexceeded", function(file){
                toastr.error("Maximum upload reached!");
            });
        }
    }

    $('#send-all').on('click', function(){
        var url = $(this).attr('data-href');
        swal({
            title: "Continue?",
			text: "This will send an invitation SMS to all Health Care Workers",
			icon: "warning",
			buttons: true,
        })
        .then((willSend)    =>  {
            if(willSend){
                window.location = url;
            }
        });
    });
</script>
@stop