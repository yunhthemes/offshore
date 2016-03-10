@extends('layouts.master')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="space50"></div>
			<h1>Add new jurisdiction</h1>
			<a href="{{ route('admin.jurisdiction.index') }}">Back</a>
				
			<div class="space50"></div>
			
			<div class="form-container">
				{!! Form::open(array('route' => 'admin.jurisdiction.store')) !!}
					<div class="field-container">
						{{ Form::text('company_type_name', null, ['class'=>'custom-input-class','placeholder'=>'Jurisdiction/Company Type']) }}
					</div>
					<div class="field-container">
						{{ Form::text('company_type_price', null, ['class'=>'custom-input-class','placeholder'=>'Jurisdiction/Company Type Price']) }}			
					</div>					
					<!-- <div class="field-container">
						{{ Form::textarea('company_type_rules', null, ['class'=>'custom-input-class','placeholder'=>'Naming Rules']) }}					
					</div> -->
					
					<div class="field-group">						
						<div class="field-container">
							{{ Form::textarea('director_name_rules', null, ['class'=>'custom-input-class','placeholder'=>'Director name rules']) }}
						</div>
						<div class="field-container">
							{{ Form::text('director_price', null, ['class'=>'custom-input-class','placeholder'=>'Nominee Director price']) }}
						</div>
					</div>

					<div class="field-group">						
						<div class="field-container">
							{{ Form::textarea('shareholder_name_rules', null, ['class'=>'custom-input-class','placeholder'=>'Shareholder name rules']) }}
						</div>
						<div class="field-container">
							{{ Form::text('shareholder_price', null, ['class'=>'custom-input-class','placeholder'=>'Nominee Shareholder price']) }}
						</div>
					</div>

					<div class="field-group">						
						<div class="field-container">
							{{ Form::textarea('secretary_name_rules', null, ['class'=>'custom-input-class','placeholder'=>'Secretary name rules']) }}
						</div>
						<div class="field-container">
							{{ Form::text('secretary_price', null, ['class'=>'custom-input-class','placeholder'=>'Nominee Secretary price']) }}
						</div>
					</div>
					
					<div class="each-service">
						<h3>Bank account</h3>
						{{ Form::hidden('service_1_name', 'Bank account', ['class'=>'custom-input-class']) }}

						<div id="cloneable">
							<div class="field-group">												
								<div class="field-container">
									<div class="custom-input-class-select-container">										
										{{ Form::select('service_1_country_1', $countries, null, ['class' => 'custom-input-class service_countries']) }}
									</div>
								</div>							
								<div class="field-container">
									{{ Form::text('service_1_price_1', null, ['class'=>'custom-input-class service_prices','placeholder'=>'Service price']) }}
								</div>
							</div>
						</div>
						<div class="pasteclone"></div>

						{{ Form::hidden('service_1_count', '1', ['id'=>'service_1_count']) }}
						<a href="#" class="add-more" data-service="service_1">Add country & price <i class="fa fa-plus"></i></a>
					</div>
					
					<div class="each-service">
						<h3>Credit/debit card</h3>
						{{ Form::hidden('service_2_name', 'Credit card', ['class'=>'custom-input-class']) }}
						
						<div id="cloneable">
							<div class="field-group">												
								<div class="field-container">
									<div class="custom-input-class-select-container">										
										{{ Form::select('service_2_country_1', $countries, null, ['class' => 'custom-input-class service_countries']) }}
									</div>
								</div>							
								<div class="field-container">
									{{ Form::text('service_2_price_1', null, ['class'=>'custom-input-class service_prices','placeholder'=>'Service price']) }}
								</div>
							</div>
						</div>
						<div class="pasteclone"></div>

						{{ Form::hidden('service_2_count', '1', ['id'=>'service_2_count']) }}
						<a href="#" class="add-more" data-service="service_2">Add country & price <i class="fa fa-plus"></i></a>
					</div>

					<div class="each-service">
						<h3>Mail forwarding</h3>
						{{ Form::hidden('service_3_name', 'Mail forwarding', ['class'=>'custom-input-class']) }}

						<div id="cloneable">
							<div class="field-group">												
								<div class="field-container">
									<div class="custom-input-class-select-container">										
										{{ Form::select('service_3_country_1', $countries, null, ['class' => 'custom-input-class service_countries']) }}
									</div>
								</div>							
								<div class="field-container">
									{{ Form::text('service_3_price_1', null, ['class'=>'custom-input-class service_prices','placeholder'=>'Service price']) }}
								</div>
							</div>
						</div>
						<div class="pasteclone"></div>

						{{ Form::hidden('service_3_count', '1', ['id'=>'service_3_count']) }}
						<a href="#" class="add-more" data-service="service_3">Add country & price <i class="fa fa-plus"></i></a>
					</div>

					<div class="each-service">
						<h3>Local Telephone</h3>
						{{ Form::hidden('service_4_name', 'Local Telephone', ['class'=>'custom-input-class']) }}

						<div id="cloneable">
							<div class="field-group">												
								<div class="field-container">
									<div class="custom-input-class-select-container">										
										{{ Form::select('service_4_country_1', $countries, null, ['class' => 'custom-input-class service_countries']) }}
									</div>
								</div>							
								<div class="field-container">
									{{ Form::text('service_4_price_1', null, ['class'=>'custom-input-class service_prices','placeholder'=>'Service price']) }}
								</div>
							</div>
						</div>
						<div class="pasteclone"></div>

						{{ Form::hidden('service_4_count', '1', ['id'=>'service_4_count']) }}
						<a href="#" class="add-more" data-service="service_4">Add country & price <i class="fa fa-plus"></i></a>
					</div>

					<div class="each-service">
						<h3>Information Services</h3>

						<div id="cloneable">
							<div class="field-group">
								<div class="field-container">
									{{ Form::text('information_service_1', null, ['class'=>'custom-input-class information_services','placeholder'=>'Information Service Name']) }}
								</div>
							</div>
						</div>
						<div class="pasteclone"></div>

						{{ Form::hidden('information_service_count', '1', ['id'=>'information_service_count']) }}
						<a href="#" class="add-more" data-service="information_service">Add information service <i class="fa fa-plus"></i></a>
					</div>
					
					{{ Form::submit('Submit', ['class'=>'custom-submit-class']) }}
			{!! Form::close() !!}
			</div>

		</div>
	</div>
</div>
<script>
	function cloneForm($el) {
		var clonedHtml = $el.clone();

		$el.parent().parent().find('.pasteclone').append(clonedHtml);
	}
	function updateHiddenField(serviceName, $this) {	
		if(serviceName=="information_service") {

			console.log($this.parent().find('.information_services').length);
			console.log('#'+serviceName+'_count')

			$('#'+serviceName+'_count').val($this.parent().find('.information_services').length);	
		}else {

			// console.log($this.parent().find('.service_countries').length);
			// console.log('#'+serviceName+'_count')

			$('#'+serviceName+'_count').val($this.parent().find('.service_countries').length);	
		}		
	}
	function updateClonedFields(serviceName, $this) {
		var id = parseInt($this.parent().find('.field-group').length);

		console.log(id);

		var $lastElAdded = $this.parent().find('.field-group').last();

		if(serviceName=="information_service") {
			$lastElAdded.find('input').attr('name', serviceName+'_'+id).val('');			
		}else {
			$lastElAdded.find('select').attr('name', serviceName+'_country_'+id).val('');
			$lastElAdded.find('input').attr('name', serviceName+'_price_'+id).val('');			
		}		
	}

	$('.add-more').on('click', function(e){
		e.preventDefault();


		var serviceName = $(this).data('service');

		cloneForm($(this).parent('.each-service').children('#cloneable').find('.field-group'));
		updateClonedFields(serviceName, $(this));
		updateHiddenField(serviceName, $(this));

	});
</script>
@endsection