@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/js/plugins/highcharts/code/css/highcharts.css') }}">
@stop

@section('content')
	<div class="row">
		<div class="col-md-9">
			<div class="ibox float-e-margins loading">
				<div class="ibox-content">
					<div class="row">
						<div class="col-md-7">
							<div id="brands-pie" style="width: 100%; height: 400px; margin: 0 auto"></div>
						</div>
						<div class="col-md-5">
							<table class="table table-bordered">
								<thead>
									<th>Brand</th>
									<th>No.</th>
								</thead>
								<tbody id="brand-table">
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="ibox">
				<div class="ibox-content" style="min-height: 450px;">
					<h3>Summary</h3>
					<hr>
					<h1 class="no-margins">{{ count($appusers) }}</h1>
					<p>Downloads to Date</p>
					<hr>
					<h1 class="no-margins">{{ number_format($month_users) }}</h1>
					<div class="stat-percent font-bold text-navy"><i class="fa fa-level-up"></i></div>
					<p>Downloads this Month</p>
					<hr>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="ibox">
				<div class="ibox-content">
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<label>Pick a Year</label>
								<select class="form-control">
									<option value="2017">2017</option>
									<option value="2018">2018</option>
								</select>
							</div>
						</div>
					</div>
					<div id="monthly-downloads" style="width: 100%; height: 400px; margin: 0 auto"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-9">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><i class="fa fa-download"></i>&nbsp;&nbsp;Download History</h5>
					<div class="ibox-tools">
						<a class="download-link">
							<i class="fa fa-download"></i>
						</a>
					</div>
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
					<h5>Total Downloads</h5>
					<h1 class="no-margins">{{ count($appusers) }}</h1>
					<div class="stat-percent font-bold text-navy"><i class="fa fa-users"></i></div>
					<small>Users</small>
				</div>
			</div>
		</div>
	</div>
@stop

@section('page_js')
@parent
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/dataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/highcharts/code/js/highcharts.src.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/js/plugins/highcharts/code/modules/exporting.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#app-users').dataTable({
			aaSorting: [[0, 'desc']]
		});

		$('.download-link').click(function(){
			window.location = "{{ url('api/appuser/download/excel') }}";
		});

		drawBrandsPie();
		drawMonthlyDownloads();
	});

	function drawBrandsPie(){
		$.ajax({
			url: "/api/appuser/brand-statistics",
			method: "GET",
			beforeSend: function(){
				$('.loading').block({
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
			success: function(res){
				$('.loading').unblock();
				Highcharts.chart('brands-pie', {
					chart: {
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false,
						type: 'pie'
					},
					title: {
						text: 'Brands'
					},
					tooltip: {
						pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: false
							},
							showInLegend: true
						}
					},
					series: [{
						name: 'Brands',
						colorByPoint: true,
						data: res
					}]
				});

				$.each(res, function(k, v){
					$('#brand-table').append("<tr><td>"+v.name+"</td><td>"+v.y+"</td></tr>");
				});
			},
			error: function(){
				$('.loading').unblock();
			}
		});
		
	}

	function drawMonthlyDownloads(month){
		Highcharts.chart('monthly-downloads', {
		    chart: {
		        type: 'column'
		    },
		    title: {
		        text: 'Monthly Application Downloads'
		    },
		    xAxis: {
		        categories: [
		            'Jan',
		            'Feb',
		            'Mar',
		            'Apr',
		            'May',
		            'Jun',
		            'Jul',
		            'Aug',
		            'Sep',
		            'Oct',
		            'Nov',
		            'Dec'
		        ],
		        crosshair: true
		    },
		    yAxis: {
		        min: 0,
		        title: {
		            text: 'No. of downloads'
		        }
		    },
		    tooltip: {
		        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
		        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
		            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
		        footerFormat: '</table>',
		        shared: true,
		        useHTML: true
		    },
		    plotOptions: {
		        column: {
		            pointPadding: 0.2,
		            borderWidth: 0
		        }
		    },
		    series: [{
		        name: 'Downloads',
		        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

		    }]
		});
	}
	
</script>
@stop