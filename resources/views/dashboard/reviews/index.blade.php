@extends('layouts.dashboard')

@section('title', 'Reported Issues (from the Mobile App)')

@section('page_css')
	@parent
	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/datatables.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/sweetalert/sweetalert.css') }}">
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<!-- <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>@yield('title')</h5>
				</div>
				<div class="ibox-content">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Email</th>
								<th>Issue</th>
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
								<td>{{ $review->issue }}</td>
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
			</div> -->
			<div class="tabs-container">
				<ul class="nav nav-tabs">
					<?php $class = 'active'; ?>
					@foreach($issues as $section => $actual_issues)
						<li class="{{ $class }}"><a data-toggle = "tab" href="#tab-{{ $section }}">{{ ucfirst($section) }}&nbsp;&nbsp;<span class="badge badge-warning">{{ count($actual_issues) }}</span></a></li>
						<?php $class = ""; ?>
					@endforeach
				</ul>
				<div class="tab-content">
					<?php $class = 'active'; ?>
					@foreach($issues as $section => $actual_issues)
					<div id="tab-{{ $section }}" class="tab-pane {{ $class }}">
						<div class="panel-body">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>Issue</th>
										<th>Comment</th>
										<th>Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($actual_issues as $issue)
									<tr>
										<td>{{ $issue->name }}</td>
										<td>{{ $issue->email }}</td>
										<td>{{ $issue->issue }}</td>
										<td>{{ $issue->comment }}</td>
										<td>{{ date('d.m.Y', strtotime($issue->created_at)) }}</td>
										<td>
											<?php
												$archive_button = '<a class="btn btn-white btn-block btn-xs update-issue" data-action= "archive" data-id = "' . $issue->id .'">Move to Archive</a>';
												$solved_button = "<a class = 'btn btn-success btn-block btn-xs update-issue' data-action= 'solve' data-id = '{$issue->id}'>Mark as Solved</a>";
											?>
											@if($section == "pending")
												<?= @$archive_button; ?>
												<?= @$solved_button; ?>
											@elseif($section == "solved")
												<?= @$archive_button; ?>
											@else
												<?= @$solved_button; ?>
											@endif
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<?php $class = ""; ?>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@stop

@section('page_js')
	@parent
	<script type="text/javascript" src="{{ asset('dashboard/js/plugins/dataTables/datatables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('dashboard/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('table').DataTable({
				pageLength: 25,
                responsive: true,
			});

			$('.update-issue').on('click', function(){
				var id = $(this).attr('data-id');
				var action = $(this).attr('data-action');
				$message = "";
				if (action == "archive") {
					$message = "Are you sure you want to archive this issue?";
				}else{
					$message = "Are you sure you want to mark this issue as solved?";
				}
				swal({
					title: "Are you sure?", 
					text: $message, 
					type: "warning",
					showCancelButton: true,
					closeOnConfirm: false,
					confirmButtonText: "Yes, Proceed!",
					confirmButtonColor: "#ec6c62"
				}, function() {
					$.ajax(
					{
						type: "post",
						url: "/api/review/update",
						data: {
							id: id,
							action: action
						},
						success: function(data){
						}
					})
					.done(function(data) {
						swal("Success!", "You have successfully updated the issue!", "success");
						location.reload();
					})
					.error(function(data) {
						swal("Oops", "There was an error while processing your request", "error");
					});
				});
			});
		});
	</script>
@stop