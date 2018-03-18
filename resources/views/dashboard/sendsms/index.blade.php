@extends('layouts.dashboard')

@section('title', 'SMS Logs')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="ibox">
			<div class="ibox-content">
                <table class="table table-bordered">
                    <thead>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Date Sent</th>
                        <th>Time Sent</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->name }}</td>
                                <td>{{ $log->phonenumber }}</td>
                                <td>{{ date('d F, Y', strtotime($log->time_sent)) }}</td>
                                <td>{{ date('h:i a', strtotime($log->time_sent)) }}</td>
                                <td>
                                    @if($log->status == 1)
                                    <span class = 'label label-primary'>Sent</span>
                                    @else
                                    <span class = 'label label-danger'>Not Sent</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan = '4'><center>No SMS Logs available</center></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop