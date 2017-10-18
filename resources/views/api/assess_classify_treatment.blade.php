<div class="tabs-container">
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#assessment"> Assessment</a></li>
		@if (@$assessment)
		<li><a data-toggle="tab" href="#signs-classification">Signs, Classification & Treatment</a></li>
		@endif
	</ul>
	<div class="tab-content">
		<div id="assessment" class="tab-pane active">
			<div class="form-group">
				<label class="control-label">Assess</label>
				<textarea class="form-control" name = "assessment" rows="8">
					@if ($assessment)
						{{ $assessment->assessment }}
					@endif
				</textarea>
			</div>

			<button id="save-assessment" class = "btn btn-primary btn-sm">Save Assessment</button>
		</div>
		@if ($assessment)
		<div id="signs-classification" class="tab-pane h-300">
			<div class="row">
				<div class="col-sm-4">
					<h2>Classification</h2>
					<hr>
					<div class="input-group">
						<input type="text" placeholder="Add new classification. " class="input input-sm form-control">
						<span class="input-group-btn">
							<button type="button" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Add Classification</button>
						</span>
					</div>

					<ul class="folder-list m-t-md" style="padding-left: 0;">
						<li><a href="#">Very Severe Disease <i class="fa fa-circle pull-right" style="color: #FFD700;"></i></a></li>
						<li><a href="#">Pneumonia <i class="fa fa-circle pull-right" style="color: red;"></i></a></li>	
					</ul>
				</div>
				<div class="col-sm-4">
					<h2>Signs</h2>
					<hr>
					<div class="input-group">
						<input type="text" placeholder="Add new sign. " class="input input-sm form-control">
						<span class="input-group-btn">
							<button type="button" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Add Sign</button>
						</span>
					</div>
				</div>
				<div class="col-sm-4">
					<h2>Treatment</h2>
					<hr>
					<div class="input-group">
						<input type="text" placeholder="Add new treatment. " class="input input-sm form-control">
						<span class="input-group-btn">
							<button type="button" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Add Treatment</button>
						</span>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
		
</div>