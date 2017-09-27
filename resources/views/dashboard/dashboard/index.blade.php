@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
	<table>
		<?php $counter = 1; ?>
		<tbody>
			@foreach($reviews as $review)
				<tr>
					<td>{{ $counter++ }} </td>
					<td>{{ $review->name }}</td>
					<td>{{ $review->rating }}</td>
					<td>{{ $review->comment }}</td>
					<td>{{ date('d.m.Y h:i a', strtotime($review->created_at)) }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop