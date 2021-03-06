@extends('layouts.email')
<p>Hi Team,</p>
<p>An issue has been logged by: {{ $issue->name }}. Below are the details</p>
<table class="table">
	<tbody>
		<tr>
			<th>Name</th>
			<td>{{ $issue->name }}</td>
		</tr>
		<tr>
			<th>Email</th>
			<td>{{ $issue->email }}</td>
		</tr>
		<tr>
			<th>Issue</th>
			<td>{{ $issue->issue }}</td>
		</tr>
		<tr>
			<th>Description</th>
			<td>{{ $issue->comment }}</td>
		</tr>
		<tr>
			<th>Time</th>
			<td>{{ date('d/m/Y h:i a', strtotime($issue->created_at)) }}</td>
		</tr>
	</tbody>
</table>

<p>Please log in to the administrator section to find out take appropriate action</p>