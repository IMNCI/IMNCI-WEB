@extends('layouts.email')

<p>Hello from IMNCI.</p>

<p>We have received an issue reported by you on {{ date('d/m/Y h:i a', strtotime($issue->created_at)) }} with the following details.</p>

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

<p>Please be assured that we are working the above issue and will revert to you soon.</p>

<p>Regards,</p>
<p><i>The IMNCI Mobile Team</i></p>