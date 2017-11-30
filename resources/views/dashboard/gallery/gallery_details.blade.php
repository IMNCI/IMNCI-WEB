<style type="text/css">
	div#image{
		background-repeat: no-repeat;
		background-size: 100%;
		width: 100%;
		height: 300px;
		background-image: url({{ route('storage_images', [$gallery->link, '']) }})
	}
</style>

<div class="row">
	<div class="col-md-12">
		<a href="{{ route('getFile', $gallery->id) }}" target="_blank">
			@if($gallery->type == "Image")
			<div id = "image" style=""></div>
			@else
			<span class="btn btn-sm btn-danger"><i class="fa fa-download"></i>&nbsp;View File</span>
			@endif
		</a>
		<table class="table" style="margin-top: 15px;">
			<tbody>
				<tr><th>Title: </th><td>{{ $gallery->title }}</td></tr>
				<tr><th>Description: </th><td>{{ $gallery->description }}</td></tr>
				<tr><th>Ailment: </th><td>{{ $gallery->ailment->ailment }}</td></tr>
				<tr><th>Category: </th><td>{{ $gallery->category->item }}</td></tr>
				<tr><th>File Size: </th><td>{{ $gallery->size }} Bytes</td></tr>
				<tr><th>File Type: </th><td>{{ $gallery->type }}</td></tr>
				<tr><th>Upload Date: </th><td>{{ date('d.M.Y', strtotime($gallery->created_at)) }}</td></tr>
			</tbody>
		</table>
	</div>
</div>