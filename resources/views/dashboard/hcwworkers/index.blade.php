@extends('layouts.dashboard')

@section('title', 'HCW Workers')

@section('action_area')
<a class = "btn btn-primary btn-sm" href = '{{ route("hcw-send-sms") }}'>Send Invitation SMS to All Workers</a>
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
                <table class="table table-bordered">
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
                            <tr>
                                <td colspan = '3'><center>No HCW Workers found here</center></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop