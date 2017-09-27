@extends('layouts.dashboard')

@section('title', 'Follow Up Care')

@section('page_css')
	@parent

	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/select2/select2.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote-bs3.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/toastr/toastr.min.css') }}">
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="ibox float-e-margins">
				<!-- <div class="ibox-title">
					<h5>Follow Up Care</h5>
				</div> -->
				<div class="ibox-content">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Age Group</label>
								{{ Form::select('age-group', $age_groups, null, ['class'=>'form-control']) }}
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Ailment</label>
								<select class = "form-control" name = "ailments"></select>
							</div>
						</div>
					</div>
					<div class="row" id="content-section">
						<div class="col-sm-6 br">
							<div class="form-group">
								<label class="control-label">Advice</label>
								<textarea class="form-control" rows="8" name = "advice_textarea"></textarea>
							</div>

							<div class="form-group">
								<button class="btn btn-primary" id="save-advice">Save Advice</button>
								<p id = "wait-save-advice">Please wait...</p>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Treatment</label>
								<textarea class="form-control" rows="8" name = "treatment_textarea"></textarea>
							</div>

							<div class="form-group">
								<button class="btn btn-primary" id="save-treatment">Save Treatment</button>
								<p id = "wait-save-treatment">Please wait...</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop


@section('page_js')
	@parent
	<script type="text/javascript" src="{{ asset('dashboard/js/plugins/select2/select2.full.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('dashboard/js/plugins/summernote/summernote.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('dashboard/js/plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript">
		var treatment_summernote;
		var advice_summernote;

		toastr.options = {
			closeButton: true,
			progressBar: true,
			showMethod: 'slideDown',
			timeOut: 4000
		};

		var emptyText = "<p></p><p></p>";
		$(document).ready(function(){
			$('#wait-save-advice').hide();
			$('#wait-save-treatment').hide();
			$('select').select2();
			treatment_summernote = $('textarea[name="treatment_textarea"]').summernote();
			advice_summernote = $('textarea[name="advice_textarea"]').summernote();
			var age_group_id = $('select[name="age-group"]').val();
			getAilmentsByAgeGroup(age_group_id);
			var ailment_id = $('select[name="ailments"]').val();

			getFollowUpData(ailment_id);
		});

		$('select[name="age-group"]').change(function(){
			getAilmentsByAgeGroup($(this).val());
		});

		$('select[name="ailments"]').change(function(){
			getFollowUpData($(this).val());
		});

		$('#save-advice').click(function(){
			var advice = $('textarea[name="advice_textarea"]').val();
			var ailment_id = $('select[name="ailments"]').val();

			var data = {
				'advice' 		: advice,
				'ailment_id'	: ailment_id
			};

			$.ajax({
				url			: '/api/addAdvice',
				type		: 'post',
				data 		: data,
				beforeSend	: function(){
					$('#wait-save-advice').show();
					$('#save-advice').attr('disabled', 'true');
				},
				success		: function(res){
					$('#save-advice').removeAttr('disabled');
					$('#wait-save-advice').hide();
					toastr.success("Follow up advice saved successfully");
				},
				error: 		 function(){
					$('#save-advice').removeAttr('disabled');
					$('#wait-save-advice').hide();
					toastr.error("There was an error while saving your data");
				} 
			});
		});

		$('#save-treatment').click(function(){
			var treatment = $('textarea[name="treatment_textarea"]').val();
			var ailment_id = $('select[name="ailments"]').val();

			var data = {
				'treatment' 		: treatment,
				'ailment_id'	: ailment_id
			};

			$.ajax({
				url			: '/api/addTreatment',
				type		: 'post',
				data 		: data,
				beforeSend	: function(){
					$('#wait-save-treatment').show();
					$('#save-treatment').attr('disabled');
				},
				success		: function(res){
					toastr.success("Follow up treatment saved successfully");
					$('#wait-save-treatment').hide();
					$('#save-treatment').removeAttr('disabled');
				},
				error: 		 function(){
					toastr.error("There was an error while saving your data");
					$('#wait-save-treatment').hide();
					$('#save-treatment').removeAttr('disabled');
				} 
			});
		});

		function getAilmentsByAgeGroup(age_group_id){
			$.get('/api/ailments/' + age_group_id, function(response){
				var data = [];
				$.each(response, function(key,value) {
					var dataObj = {};

					dataObj.id = value.id;
					dataObj.text = value.ailment;

					data.push(dataObj);
				}); 

				$('select[name="ailments"]').empty();
				$('select[name="ailments"]').select2({
					data: data
				});

				var ailment_id = $('select[name="ailments"]').val();

				getFollowUpData(ailment_id);
			});
		}

		function getFollowUpData($ailment_id){
			data = {
				'ailment_id' : $ailment_id
			};

			$.post('/api/followupbyailment', data, function(res){
				if (res.advice != null) {
					$('textarea[name="advice_textarea"]').val(res.advice.advice);
					advice_summernote.summernote('code', res.advice.advice);
				}else{
					advice_summernote.summernote('code', emptyText);
				}
				if (res.treatment != null) {
					treatment_summernote.summernote('code', res.treatment.treatment);
				}else{
					treatment_summernote.summernote('code', emptyText);
				}
			});
		}
	</script>
@stop