@extends('layouts.dashboard')
@section('title', 'Gallery Ailments')
@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="{{ route('gallery') }}">Gallery</a></li>
	<li class="active">Gallery Ailments</li>
</ol>
@stop

@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="ibox">
			<div class="ibox-content">
				{{ Form::open(array('url' => 'gallery-ailments')) }}
					<div class="form-group">
						<div class="input-group">
							<input type="text" placeholder="Ailment" class="input-sm form-control" name="ailment" required /> 
							<span class="input-group-btn"><button type="submit" class="btn btn-sm btn-white"> Add Ailment</button> </span>
						</div>
					</div>
				{{ Form::close() }}

				<table class="table">
					<thead>
						<th style="width: 80%;">Ailment</th>
					</thead>
					<tbody>
						@forelse($ailments as $ailment)
							<tr>
								<td>{{$ailment->ailment}}</td>
								<td>
									<a href="#" class="btn btn-xs btn-danger">Remove</a>
								</td>
							</tr>
						@empty
						<tr>
							<td colspan="2"><center>There are no ailments yet</center></td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop