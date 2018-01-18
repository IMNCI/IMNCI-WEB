@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('page_css')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/js/plugins/highcharts/code/css/highcharts.css') }}">
<style type="text/css">
	.blockOverlay{
		background-color: #FFF !important;
		opacity: 0.9 !important;
	}
</style>
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="ibox">
				<div class="ibox-content" id="monthly-downloads-main">
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<label>Pick a Year</label>
								<select class="form-control" name="monthly-downloads-year">
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
		<div class="col-md-4">
			<div class="ibox">
				<div class="ibox-content" id="gender-chart-main">
					<div id="gender-chart" style="height: 300px;"></div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="ibox">
				<div class="ibox-content" id="cohort-chart-main">
					<div id="cohort-chart" style="height: 300px;"></div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="ibox">
				<div class="ibox-content" id="sector-chart-main">
					<div id="sector-chart" style="height: 300px;"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="ibox">
				<div class="ibox-content" id="profession-chart-main">
					<div id="profession-chart" style="height: 300px;"></div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="ibox">
				<div class="ibox-content" id="cadre-chart-main">
					<div id="cadre-chart" style="height: 300px;"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="ibox">
				<div class="ibox-content p-0" id = "world-map-main">
					<div id="world-map" style="height: 300px;"></div>
				</div>
			</div>
			
		</div>
		<div class="col-md-4">
			<div class="ibox">
				<div class="ibox-content" id = "county-chart-main">
					<div id="county-chart" style="height: 300px;"></div>
				</div>
			</div>
		</div>
	</div>
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
				<div class="ibox-content" id="version-chart-main">
					<div class="row">
						<div class="col-md-12">
							<div id="version-chart" style="height: 400px;"></div>
						</div>
					</div>
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
<script src="{{ asset('dashboard/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('dashboard/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script type="text/javascript">
	var loader = '<div class="sk-spinner sk-spinner-pulse"></div>';

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
	$(document).ready(function(){
		$('#app-users').dataTable({
			aaSorting: [[0, 'desc']]
		});

		$('.download-link').click(function(){
			window.location = "{{ url('api/appuser/download/excel') }}";
		});

		drawBrandsPie();
		drawMonthlyDownloads($('select[name="monthly-downloads-year"]').val());
		drawAndroidVersionDistribution();
		drawGenderChart();
		drawCohortChart();
		drawSectorChart();
		drawCadreChart();
		drawProfessionChart();
		drawMap();
		drawCountyChart();
	});

	$('select[name="monthly-downloads-year"]').change(function(){
		drawMonthlyDownloads($(this).val());
	});

	function drawMap(){
		var mapData = {
			"KE": 35
		};

		$('#world-map').vectorMap({
			map: 'world_mill_en',
			backgroundColor: "transparent",
			regionStyle: {
				initial: {
					fill: '#e4e4e4',
					"fill-opacity": 0.9,
					stroke: 'none',
					"stroke-width": 0,
					"stroke-opacity": 0
				}
			},

			series: {
				regions: [{
					values: mapData,
					scale: ["#1ab394", "#22d6b1"],
					normalizeFunction: 'polynomial'
				}]
			},
		});
	}

	function drawPie(container, title, series){
		Highcharts.chart(container, {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: title
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
			series: series
		});
	}

	function drawCountyChart(){
		$.ajax({
			url: "/api/profile/county-statistics",
			method: "GET",
			beforeSend: function(){
				$('#county-chart-main').block(blockObj);
			},
			success: function(res){
				$('#county-chart-main').unblock();
				var series_data = [];
				var data = [];
				$.each(res, function(k, v){
					dataObj = {};
					dataObj.name = v.county;
					dataObj.y = v.total;
					data.push(dataObj);
				});
				seriesObj = {
					name: 'County',
					colorByPoint: true,
					data: data
				};
				series_data.push(seriesObj);
				drawPie("county-chart", "County Distribution", series_data);
			},
			error: function(){
				$('#county-chart-main').unblock();
				toastr.error("Error", "There was an error");
			}
		});
	}

	function drawGenderChart(){
		$.ajax({
			url: "/api/profile/gender-statistics",
			method: "GET",
			beforeSend: function(){
				$('#gender-chart-main').block(blockObj);
			},
			success: function(res){
				$('#gender-chart-main').unblock();
				var series_data = [];
				var data = [];
				$.each(res, function(k, v){
					dataObj = {};
					dataObj.name = v.gender;
					dataObj.y = v.total;
					data.push(dataObj);
				});
				seriesObj = {
					name: 'Gender',
					colorByPoint: true,
					data: data
				};
				series_data.push(seriesObj);
				drawPie("gender-chart", "Gender Distribution", series_data);
			},
			error: function(){
				$('#gender-chart-main').unblock();
				toastr.error("Error", "There was an error");
			}
		});
	}

	function drawCohortChart(){
		$.ajax({
			url: "/api/profile/cohort-statistics",
			method: "GET",
			beforeSend: function(){
				$('#cohort-chart-main').block(blockObj);
			},
			success: function(res){
				$('#cohort-chart-main').unblock();
				var series_data = [];
				var data = [];
				$.each(res, function(k, v){
					dataObj = {};
					dataObj.name = v.age_group;
					dataObj.y = v.total;
					data.push(dataObj);
				});
				seriesObj = {
					name: 'Cohort',
					colorByPoint: true,
					data: data
				};
				series_data.push(seriesObj);
				drawPie("cohort-chart", "Cohort Distribution", series_data);
			},
			error: function(){
				$('#gender-chart-main').unblock();
				toastr.error("Error", "There was an error pulling cohort distribution");
			}
		});
	}

	function drawSectorChart(){
		$.ajax({
			url: "/api/profile/sector-statistics",
			method: "GET",
			beforeSend: function(){
				$('#sector-chart-main').block(blockObj);
			},
			success: function(res){
				$('#sector-chart-main').unblock();
				var series_data = [];
				var data = [];
				$.each(res, function(k, v){
					dataObj = {};
					dataObj.name = v.sector;
					dataObj.y = v.total;
					data.push(dataObj);
				});
				seriesObj = {
					name: 'Sector',
					colorByPoint: true,
					data: data
				};
				series_data.push(seriesObj);
				drawPie("sector-chart", "Sector Distribution", series_data);
			},
			error: function(){
				$('#gender-chart-main').unblock();
				toastr.error("Error", "There was an error pulling sector distribution");
			}
		});
	}

	function drawCadreChart(){
		$.ajax({
			url: "/api/profile/cadre-statistics",
			method: "GET",
			beforeSend: function(){
				$('#cadre-chart-main').block(blockObj);
			},
			success: function(res){
				$('#cadre-chart-main').unblock();
				var series_data = [];
				var data = [];
				$.each(res, function(k, v){
					dataObj = {};
					dataObj.name = v.cadre;
					dataObj.y = v.total;
					data.push(dataObj);
				});
				seriesObj = {
					name: 'Cadre',
					colorByPoint: true,
					data: data
				};
				series_data.push(seriesObj);
				drawPie("cadre-chart", "Cadre Distribution", series_data);
			},
			error: function(){
				$('#gender-chart-main').unblock();
				toastr.error("Error", "There was an error pulling cadre distribution");
			}
		});
	}

	function drawBrandsPie(){
		$.ajax({
			url: "/api/appuser/brand-statistics",
			method: "GET",
			beforeSend: function(){
				$('.loading').block(blockObj);
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

	function drawProfessionChart(){
		$.ajax({
			url: "/api/profile/profession-statistics/",
			method: "GET",
			beforeSend: function(){
				$('#profession-chart-main').block(blockObj);
			},
			success: function(res){
				$('#profession-chart-main').unblock();
				data = [];
				categories = [];

				$.each(res, function(k, v){
					categories.push(v.profession);
					data.push(v.total);
				});
				Highcharts.chart('profession-chart', {
				    chart: {
				        type: 'column'
				    },
				    title: {
				        text: 'Profession Distribution'
				    },
				    xAxis: {
				        categories: categories,
				        crosshair: true
				    },
				    yAxis: {
				        min: 0,
				        title: {
				            text: 'No. of Participants'
				        }
				    },
				    tooltip: {
				        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				            '<td style="padding:0"><b>{point.y}</b></td></tr>',
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
				        name: 'Registrations',
				        data: data

				    }]
				});
			}, error: function(){
				$('#profession-chart-main').unblock();
				toastr.error('Error', "There was an error loading the monthly downloads chart");
			}
		});
	}

	function drawMonthlyDownloads(year){
		$.ajax({
			url: "/api/appuser/monthly-downloads/" + year,
			method: "GET",
			beforeSend: function(){
				$('#monthly-downloads-main').block(blockObj);
			},
			success: function(res){
				$('#monthly-downloads-main').unblock();
				data = [];
				categories = [];

				$.each(res, function(k, v){
					categories.push(v.month);
					data.push(v.download);
				});
				Highcharts.chart('monthly-downloads', {
				    chart: {
				        type: 'column'
				    },
				    title: {
				        text: 'Monthly Application Downloads'
				    },
				    xAxis: {
				        categories: categories,
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
				            '<td style="padding:0"><b>{point.y}</b></td></tr>',
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
				        name: 'Downloads in ' + year,
				        data: data

				    }]
				});
			}, error: function(){
				$('#monthly-downloads-main').unblock();
				toastr.error('Error', "There was an error loading the monthly downloads chart");
			}
		});
		
	}

	function drawAndroidVersionDistribution(){
		$.ajax({
			url: "/api/appuser/android-version-distribution",
			method: "GET",
			beforeSend: function(){
				$('#version-chart-main').block(blockObj);
			},
			success: function(res){
				$('#version-chart-main').unblock();
				var series = [];
				res.reverse();
				$.each(res, function(k, v){
					data = [];
					data.push(v.total);
					seriesObj = {
						name: "Android " + v.android_release,
						data: data
					};

					series.push(seriesObj);
				});
				Highcharts.chart('version-chart', {
					chart: {
						type: 'bar'
					},
					title: {
						text: 'Android Version Distribution'
					},
					xAxis: {
						categories: ['Android Version']
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Registered Percentages'
						}
					},
					legend: {
						reversed: false
					},
					plotOptions: {
						series: {
							stacking: 'percent'
						}
					},
					series: series
				});
			},error: function(){
				$('#version-chart-main').unblock();
				toastr.error("Error", "Could not load the Android Distribution chart");
			}
		});
		
	}
	
</script>
@stop