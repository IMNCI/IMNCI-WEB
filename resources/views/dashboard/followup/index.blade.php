@extends('layouts.dashboard')

@section('title', 'Follow Up Care')

@section('action_area')
<a class="btn btn-primary btn-sm" href="/ailments">Manage Ailments</a>
@stop

@section('page_css')
	@parent

	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/select2/select2.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/summernote/summernote-bs3.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/toastr/toastr.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/plugins/sweetalert/sweetalert.css') }}">

	<style type="text/css">
		.hidden{
			display: none;
		}
	</style>
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="ibox float-e-margins">
				<!-- <div class="ibox-title">
					<h5>Follow Up Care</h5>
				</div> -->
				<div class="ibox-content" id="follow-up-form">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Cohort</label>
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

							<!-- <div class="form-group">
								<button class="btn btn-primary" id="save-advice">Save Advice</button>
								<p id = "wait-save-advice">Please wait...</p>
							</div> -->
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Treatment</label>
								<textarea class="form-control" rows="8" name = "treatment_textarea"></textarea>
							</div>

							<!-- <div class="form-group">
								<button class="btn btn-primary" id="save-treatment">Save Treatment</button>
								<p id = "wait-save-treatment">Please wait...</p>
							</div> -->
						</div>

						<button id="save-advice-treatment-confirmation" class="btn btn-success btn-block">Save Advice & Treatment</button>

						<button id="save-advice-treatment" class="btn btn-primary hidden btn-block">Save Advice & Treatment</button>
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
	<script type="text/javascript" src="{{ asset('dashboard/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('dashboard/js/jquery.blockUI.js') }}"></script>
	<script type="text/javascript">
		var treatment_summernote;
		var advice_summernote;

		toastr.options = {
			closeButton: true,
			progressBar: true,
			showMethod: 'slideDown',
			timeOut: 4000
		};

		$summernote_options = {
			placeholder: 'Type here...',
			height: '300px'
		};

		$(document).ready(function(){
			$('#wait-save-advice').hide();
			$('#wait-save-treatment').hide();
			$('select').select2();
			
			treatment_summernote = $('textarea[name="treatment_textarea"]').summernote($summernote_options);
			advice_summernote = $('textarea[name="advice_textarea"]').summernote($summernote_options);
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

		$('#save-advice-treatment-confirmation').click(function(){
			var treatment = $('textarea[name="treatment_textarea"]').val();
			var advice = $('textarea[name="advice_textarea"]').val();
			if(treatment != "" && advice != ""){
				swal("Review", "Please review this content before you submit. Once submitted, it cannot be undone", "info");
				$('#save-advice-treatment-confirmation').addClass('hidden');
				$('#save-advice-treatment').removeClass('hidden');
			}else{
				swal("Wait!", "You cannot save this follow up care content without having entered both advice and treatment", "error");
			}
		});

		$('#save-advice-treatment').click(function(){
			var treatment = $('textarea[name="treatment_textarea"]').val();
			var advice = $('textarea[name="advice_textarea"]').val();
			var ailment_id = $('select[name="ailments"]').val();

			
			var data = {
				'advice' 		: advice,
				'treatment' 	: treatment,
				'ailment_id'	: ailment_id
			};

			$.ajax({
				url			: '/api/addAdviceTreatment',
				type		: 'post',
				data 		: data,
				beforeSend	: function(){
					$('#follow-up-form').block({
						message: ""
					});
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
			})
			.done(function(){
				$('#save-advice-treatment-confirmation').removeClass('hidden');
				$('#save-advice-treatment').addClass('hidden');
				$('#follow-up-form').unblock();
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
				$('#save-advice-treatment-confirmation').removeClass('hidden');
				$('#save-advice-treatment').addClass('hidden');
				if (res.advice != null && res.advice != " ") {
					$('textarea[name="advice_textarea"]').val(res.advice.advice);
					advice_summernote.summernote('code', res.advice.advice);
				}else{
					advice_summernote.summernote('code', "");
				}
				if (res.treatment != null && res.advice != " ") {
					treatment_summernote.summernote('code', res.treatment.treatment);
				}else{
					treatment_summernote.summernote('code', "");
				}
			});
		}
	</script>
@stop