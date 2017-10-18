@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/datatables.min.css') }}">
@stop

@section('content')
	<div class="row">
		<div class="col-md-8">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					App Users
				</div>
				<div class="ibox-content">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered" id="app-users">
								<thead>
									<tr>
										<th>#</th>
										<th>Brand</th>
										<th>Device</th>
										<th>Model</th>
										<th>Android Version</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
									<?php $counter = 1;?>
									@foreach($appusers as $appuser)
									<tr>
										<td>{{ $counter }}</td>
										<td>{{ $appuser->brand }}</td>
										<td>{{ $appuser->device }}</td>
										<td>{{ $appuser->model }}</td>
										<td>Android {{ $appuser->android_release }}</td>
										<td>{{ date('d.m.Y \a\t h:i a', strtotime($appuser->opened_at)) }}</td>
									</tr>
									<?php $counter++; ?>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			
		</div>
	</div>
@stop

@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/dataTables/datatables.min.js') }}"></script>
<script type="text/javascript">
	$('#app-users').dataTable();
</script>
@stop