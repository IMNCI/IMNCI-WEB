@extends('layouts.dashboard')

@section('page_css')
	@parent
    <style>
        .file-name p{
            overflow: hidden;
        }

        .file-box{
            width: 0;
        }
    </style>
@stop

@section('title')
{{ __('dashboard.documentation') }}
@stop
@section('content')
<div class = 'row'>
    <?php
        $files = Storage::files('documents');
    ?>

    @forelse($files as $file)
        <div class="col-md-3">
            <div class="file">
                <a target = '_blank' href="{{ Storage::url($file) }}">
                    <span class="corner"></span>
                    <div class="icon">
                        <i class="fa fa-file-pdf-o"></i>
                    </div>
                    <div class="file-name">
                        <p>{{ substr($file, strpos($file, "/") + 1) }}</p>
                        <small>{{ date('M d, Y', Storage::lastModified($file)) }}</small>
                    </div>
                </a>
            </div>
        </div>
    @empty

    @endforelse
</div>
@stop