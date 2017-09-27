@extends('layouts.dashboard')

@section('title', 'Reviews')

@section('page_css')
	@parent
	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/datatables.min.css') }}">
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>@yield('title')</h5>

					<div class="ibox-tools">
						<span class="label label-primary">Average Rating: {{ $average }}</span>
					</div>
				</div>
				<div class="ibox-content">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Email</th>
								<th>Rating</th>
								<th>Comment</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							<?php $counter = 1;?>
							@forelse ($reviews as $review)
							<tr>
								<td>{{ $counter }}</td>
								<td>{{ $review->name }}</td>
								<td>{{ $review->email }}</td>
								<td>{{ $review->rating }}</td>
								<td>{{ $review->comment }}</td>
								<td>{{ date('d.m.Y', strtotime($review->created_at)) }}</td>
							</tr>
							<?php $counter++; ?>
							@empty
							<tr>
								<td colspan="6"><center>No reviews at the moment</center></td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop

@section('page_js')
	@parent
	<script type="text/javascript" src="{{ asset('dashboard/js/plugins/dataTables/datatables.min.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('table').DataTable({
				pageLength: 25,
                responsive: true,
			});
		});
	</script>
@stop