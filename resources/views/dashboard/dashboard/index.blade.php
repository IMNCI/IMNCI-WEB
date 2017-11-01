@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/datatables.min.css') }}">
@stop

@section('content')
	<div class="row">
		<div class="col-md-9">
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
									<?php $counter = count($appusers);?>
									@foreach($appusers as $appuser)
									<tr>
										<td>{{ $counter }}</td>
										<td>{{ $appuser->brand }}</td>
										<td>{{ $appuser->device }}</td>
										<td>{{ $appuser->model }}</td>
										<td>Android {{ $appuser->android_release }}</td>
										<td>{{ date('d.m.Y \a\t h:i a', strtotime($appuser->opened_at)) }}</td>
									</tr>
									<?php $counter--; ?>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="ibox">
				<div class="ibox-content">
					<h5>Users</h5>
					<h1 class="no-margins">{{ count($appusers) }}</h1>
					<div class="stat-percent font-bold text-navy"><i class="fa fa-users"></i></div>
					<small>Total users</small>
				</div>
			</div>
			<div class="ibox">
				<div class="ibox-content">
					<h5>Rating</h5>
					<h1 class="no-margins">{{ number_format($rating, 1) }}</h1>
					<div class="stat-percent font-bold text-navy"><i class="fa fa-star-half-o"></i></div>
					<small>Average Rating</small>
				</div>
			</div>
		</div>
	</div>
@stop

@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/dataTables/datatables.min.js') }}"></script>
<script type="text/javascript">
	$('#app-users').dataTable({
		aaSorting: [[0, 'desc']]
	});
</script>
@stop