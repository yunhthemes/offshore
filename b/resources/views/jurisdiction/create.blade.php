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
						{{ Form::label('company_type_name', 'Jurisdiction/Company type')}}
						{{ Form::text('company_type_name', null, ['class'=>'custom-input-class']) }}
					</div>
					<div class="field-container">
						{{ Form::label('company_type_price', 'Jurisdiction/Company type price (USD)')}}
						{{ Form::text('company_type_price', null, ['class'=>'custom-input-class']) }}			
					</div>										
					<div class="field-container">
						{{ Form::label('company_type_price_eu', 'Jurisdiction/Company type price (EUR)')}}
						{{ Form::text('company_type_price_eu', null, ['class'=>'custom-input-class']) }}			
					</div>										
					
					<div class="field-group">						
						<div class="field-container">
							{{ Form::label('director_name_rules', 'Director name rules')}}
							{{ Form::textarea('director_name_rules', null, ['class'=>'custom-input-class']) }}
						</div>
						<div class="field-container">
							{{ Form::label('director_price', 'Nominee director price (USD)')}}
							{{ Form::text('director_price', null, ['class'=>'custom-input-class']) }}
						</div>
						<div class="field-container">
							{{ Form::label('director_price_eu', 'Nominee director price (EUR)')}}
							{{ Form::text('director_price_eu', null, ['class'=>'custom-input-class']) }}
						</div>
					</div>

					<div class="field-group">						
						<div class="field-container">
							{{ Form::label('shareholder_name_rules', 'Shareholder name rules')}}
							{{ Form::textarea('shareholder_name_rules', null, ['class'=>'custom-input-class']) }}
						</div>
						<div class="field-container">
							{{ Form::label('shareholder_price', 'Nominee shareholder price (USD)')}}
							{{ Form::text('shareholder_price', null, ['class'=>'custom-input-class']) }}
						</div>
						<div class="field-container">
							{{ Form::label('shareholder_price_eu', 'Nominee shareholder price (EUR)')}}
							{{ Form::text('shareholder_price_eu', null, ['class'=>'custom-input-class']) }}
						</div>
					</div>

					<div class="field-group">						
						<div class="field-container">
							{{ Form::label('secretary_name_rules', 'Secretary name rules')}}
							{{ Form::textarea('secretary_name_rules', null, ['class'=>'custom-input-class']) }}
						</div>
						<div class="field-container">
							{{ Form::label('secretary_price', 'Nominee secretary price (USD)')}}
							{{ Form::text('secretary_price', null, ['class'=>'custom-input-class']) }}
						</div>
						<div class="field-container">
							{{ Form::label('secretary_price_eu', 'Nominee secretary price (EUR)')}}
							{{ Form::text('secretary_price_eu', null, ['class'=>'custom-input-class']) }}
						</div>
					</div>
					
					<div class="each-service">
						<h3 class="form-header">Bank account</h3>
						{{ Form::hidden('service_1_name', 'Bank account', ['class'=>'custom-input-class']) }}

						<div id="cloneable">
							<div class="field-group">												
								<div class="field-container">
									{{ Form::label('service_1_country_1', 'Bank account country')}}
									<div class="custom-input-class-select-container">																				
										{{ Form::select('service_1_country_1', $countries, null, ['class' => 'custom-input-class service_countries']) }}
									</div>
								</div>							
								<div class="field-container">
									{{ Form::label('service_1_price_1', 'Bank account price (USD)')}}
									{{ Form::text('service_1_price_1', null, ['class'=>'custom-input-class service_prices']) }}
								</div>
								<div class="field-container">
									{{ Form::label('service_1_price_eu_1', 'Bank account price (EUR)')}}
									{{ Form::text('service_1_price_eu_1', null, ['class'=>'custom-input-class service_prices']) }}
								</div>
							</div>
						</div>
						<div class="pasteclone"></div>

						{{ Form::hidden('service_1_count', '1', ['id'=>'service_1_count']) }}
						<a href="#" class="add-more" data-service="service_1">Add country & price <i class="fa fa-plus"></i></a>
					</div>
					
					<div class="each-service">
						<h3 class="form-header">Credit/debit card</h3>
						{{ Form::hidden('service_2_name', 'Credit card', ['class'=>'custom-input-class']) }}
						
						<div id="cloneable">
							<div class="field-group">												
								<div class="field-container">
									{{ Form::label('service_2_country_1', 'Credit/debit card country')}}
									<div class="custom-input-class-select-container">										
										{{ Form::select('service_2_country_1', $countries, null, ['class' => 'custom-input-class service_countries']) }}
									</div>
								</div>							
								<div class="field-container">
									{{ Form::label('service_2_price_1', 'Credit/debit card price (USD)')}}
									{{ Form::text('service_2_price_1', null, ['class'=>'custom-input-class service_prices']) }}
								</div>
								<div class="field-container">
									{{ Form::label('service_2_price_eu_1', 'Credit/debit card price (EUR)')}}
									{{ Form::text('service_2_price_eu_1', null, ['class'=>'custom-input-class service_prices']) }}
								</div>
							</div>
						</div>
						<div class="pasteclone"></div>

						{{ Form::hidden('service_2_count', '1', ['id'=>'service_2_count']) }}
						<a href="#" class="add-more" data-service="service_2">Add country & price <i class="fa fa-plus"></i></a>
					</div>

					<div class="each-service">
						<h3 class="form-header">Mail forwarding</h3>
						{{ Form::hidden('service_3_name', 'Mail forwarding', ['class'=>'custom-input-class']) }}

						<div id="cloneable">
							<div class="field-group">												
								<div class="field-container">
									{{ Form::label('service_3_country_1', 'Mail forwarding country')}}
									<div class="custom-input-class-select-container">										
										{{ Form::select('service_3_country_1', $countries, null, ['class' => 'custom-input-class service_countries']) }}
									</div>
								</div>							
								<div class="field-container">
									{{ Form::label('service_3_price_1', 'Mail forwarding price (USD)')}}
									{{ Form::text('service_3_price_1', null, ['class'=>'custom-input-class service_prices']) }}
								</div>
								<div class="field-container">
									{{ Form::label('service_3_price_eu_1', 'Mail forwarding price (EUR)')}}
									{{ Form::text('service_3_price_eu_1', null, ['class'=>'custom-input-class service_prices']) }}
								</div>
							</div>
						</div>
						<div class="pasteclone"></div>

						{{ Form::hidden('service_3_count', '1', ['id'=>'service_3_count']) }}
						<a href="#" class="add-more" data-service="service_3">Add country & price <i class="fa fa-plus"></i></a>
					</div>

					<div class="each-service">
						<h3 class="form-header">Local telephone</h3>
						{{ Form::hidden('service_4_name', 'Local Telephone', ['class'=>'custom-input-class']) }}

						<div id="cloneable">
							<div class="field-group">												
								<div class="field-container">
									{{ Form::label('service_4_country_1', 'Local telephone country')}}
									<div class="custom-input-class-select-container">										
										{{ Form::select('service_4_country_1', $countries, null, ['class' => 'custom-input-class service_countries']) }}
									</div>
								</div>							
								<div class="field-container">
									{{ Form::label('service_4_price_1', 'Local telephone price (USD)')}}
									{{ Form::text('service_4_price_1', null, ['class'=>'custom-input-class service_prices']) }}
								</div>
								<div class="field-container">
									{{ Form::label('service_4_price_eu_1', 'Local telephone price (EUR)')}}
									{{ Form::text('service_4_price_eu_1', null, ['class'=>'custom-input-class service_prices']) }}
								</div>
							</div>
						</div>
						<div class="pasteclone"></div>

						{{ Form::hidden('service_4_count', '1', ['id'=>'service_4_count']) }}
						<a href="#" class="add-more" data-service="service_4">Add country & price <i class="fa fa-plus"></i></a>
					</div>

					<div class="each-service">
						<h3 class="form-header">Information services</h3>

						<div id="cloneable">
							<div class="field-group">
								<div class="field-container">
									{{ Form::label('information_service_1', 'Information services name')}}
									{{ Form::text('information_service_1', null, ['class'=>'custom-input-class information_services']) }}
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