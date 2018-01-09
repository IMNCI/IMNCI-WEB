@extends('layouts.dashboard')

@section('title', 'User Profiles')

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/datatables.min.css') }}">
@stop

@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/dataTables/datatables.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#profile-table').dataTable();
	});
</script>
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				<table class="table table-striped" id="profile-table">
					<thead>
						<th>Email</th>
						<th>Phone</th>
						<th>Gender</th>
						<th>Age Group</th>
						<th>County</th>
						<th>Profession</th>
						<th>Cadre</th>
						<th>Sector</th>
						<th>Created</th>
					</thead>
					<tbody>
						@forelse($profiles as $profile)
						<td>{{ $profile->email }}</td>
						<td>{{ $profile->phone }}</td>
						<td>{{ $profile->gender }}</td>
						<td>{{ $profile->age_group }}</td>
						<td>{{ $profile->county }}</td>
						<td>{{ $profile->profession }}</td>
						<td>{{ $profile->cadre }}</td>
						<td>{{ $profile->sector }}</td>
						<td>{{ date('d/M/Y H:i', strtotime($profile->created_at)) }}</td>
						@empty
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop