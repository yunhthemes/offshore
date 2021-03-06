@extends('layouts.master')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="space50"></div>
			<h1>Edit a company type</h1>
			<a href="{{ route('admin.jurisdiction.index') }}"><button class="custom-submit-class">Return to company types</button></a>
				
			<div class="space50"></div>
			
			<div class="form-container">
				{{ Form::open([ 'route' => ['admin.jurisdiction.update', $company_type->id ], 'method' => 'put', 'id' => 'edit_company_type' ]) }}
					<div class="field-container">
						{{ Form::label('company_type_name', 'Company type')}}
						{{ Form::text('company_type_name', $company_type->name, ['class'=>'custom-input-class']) }}
					</div>
					<div class="field-container">
						{{ Form::label('jurisdiction', 'Jurisdiction')}}
						{{ Form::text('jurisdiction', $company_type->jurisdiction, ['class'=>'custom-input-class']) }}
					</div>
					<div class="field-container">
						{{ Form::label('company_name_rules', 'Company name rules')}}
						{{ Form::textarea('company_name_rules', $company_type->rules, ['class'=>'custom-input-class']) }}
					</div>
					@if(count($company_type->shareholders) > 0)
					{{ Form::hidden('shareholder_id', $company_type->shareholders[0]->id) }}
					@endif
					<div class="field-container">
						{{ Form::label('shareholder_name_rules', 'Shareholder rules')}}
						@if(count($company_type->shareholders) > 0)
							{{ Form::textarea('shareholder_name_rules', $company_type->shareholders[0]->name_rules, ['class'=>'custom-input-class']) }}
						@else
							{{ Form::textarea('shareholder_name_rules', "", ['class'=>'custom-input-class']) }}
						@endif
					</div>
					
					@if(count($company_type->directors) > 0)
						{{ Form::hidden('director_id', $company_type->directors[0]->id) }}
					@endif
					<div class="field-container">
						{{ Form::label('director_name_rules', 'Director rules')}}
						@if(count($company_type->directors) > 0)
							{{ Form::textarea('director_name_rules', $company_type->directors[0]->name_rules, ['class'=>'custom-input-class']) }}
						@else
							{{ Form::textarea('director_name_rules', "", ['class'=>'custom-input-class']) }}
						@endif
					</div>
					
					@if(count($company_type->secretaries) > 0)
						{{ Form::hidden('secretary_id', $company_type->secretaries[0]->id) }}
					@endif
					<div class="field-container">
						{{ Form::label('secretary_name_rules', 'Secretary rules')}}
						@if(count($company_type->secretaries) > 0)
							{{ Form::textarea('secretary_name_rules', $company_type->secretaries[0]->name_rules, ['class'=>'custom-input-class']) }}
						@else
							{{ Form::textarea('secretary_name_rules', "", ['class'=>'custom-input-class']) }}
						@endif
					</div>

					<div class="field-container">
						{{ Form::label('price_label', 'Incorporation charge label (use in individual corporation page)')}}
						{{ Form::text('price_label', $company_type->price_label, ['class'=>'custom-input-class']) }}
					</div>

					<div class="field-container">
						{{ Form::label('company_type_price_eu', 'Incorporation charge €')}}
						{{ Form::text('company_type_price_eu', $company_type->price_eu, ['class'=>'custom-input-class']) }}
					</div>					
					<div class="field-container">
						{{ Form::label('company_type_price', 'Incorporation charge $')}}
						{{ Form::text('company_type_price', $company_type->price, ['class'=>'custom-input-class']) }}
					</div>
					
					{{ Form::hidden('service_3_id', (count($company_type->services) > 0)  ? $company_type->services[0]->id : '') }}
					{{ Form::hidden('service_3_name', 'Registered office annual fee (compulsory)') }}
					{{ Form::hidden('service_3_country_1_id', (count($company_type->services) > 0)  ? $company_type->services[0]->countries[0]->pivot->id : '') }}
					{{ Form::hidden('service_3_country_1', '2') }}

					<div class="field-container">
						{{ Form::label('service_3_price_eu_1', 'Registered office fee €')}}
						{{ Form::text('service_3_price_eu_1', (count($company_type->services) > 0)  ? $company_type->services[0]->countries[0]->pivot->price_eu : '', ['class'=>'custom-input-class service_prices_eu']) }}
					</div>					
					<div class="field-container">
						{{ Form::label('service_3_price_1', 'Registered office fee $')}}
						{{ Form::text('service_3_price_1', (count($company_type->services) > 0)  ? $company_type->services[0]->countries[0]->pivot->price : '', ['class'=>'custom-input-class service_prices']) }}
					</div>	

					<div class="field-container">
						{{ Form::label('shareholder_price_eu', 'Shareholder fee €')}}
						{{ Form::text('shareholder_price_eu', (count($company_type->shareholders) > 0)  ? $company_type->shareholders[0]->price_eu : '', ['class'=>'custom-input-class']) }}
					</div>
					<div class="field-container">
						{{ Form::label('shareholder_price', 'Shareholder fee $')}}
						{{ Form::text('shareholder_price', (count($company_type->shareholders) > 0)  ? $company_type->shareholders[0]->price : '', ['class'=>'custom-input-class']) }}
					</div>						
					<div class="field-container">
						{{ Form::label('director_price_eu', 'Director fee €')}}
						{{ Form::text('director_price_eu', (count($company_type->directors) > 0)  ? $company_type->directors[0]->price_eu : '', ['class'=>'custom-input-class']) }}
					</div>		
					<div class="field-container">
						{{ Form::label('director_price', 'Director fee $')}}
						{{ Form::text('director_price', (count($company_type->directors) > 0)  ? $company_type->directors[0]->price : '', ['class'=>'custom-input-class']) }}
					</div>								
					<div class="field-container">
						{{ Form::label('secretary_price_eu', 'Secretary fee €')}}
						{{ Form::text('secretary_price_eu', (count($company_type->secretaries) > 0)  ? $company_type->secretaries[0]->price_eu : '', ['class'=>'custom-input-class']) }}
					</div>
					<div class="field-container">
						{{ Form::label('secretary_price', 'Secretary fee $')}}
						{{ Form::text('secretary_price', (count($company_type->secretaries) > 0)  ? $company_type->secretaries[0]->price : '', ['class'=>'custom-input-class']) }}
					</div>
					
					<div class="each-service">
						<h3 class="form-header">Bank accounts</h3>						
						{{ Form::hidden('service_1_name', 'Bank accounts') }}
						
						@if(count($company_type->services) > 0 && isset($company_type->services[1]))
							{{ Form::hidden('service_1_id', (count($company_type->services) > 0 && isset($company_type->services[1]))  ? $company_type->services[1]->id : '') }}

							@foreach($company_type->services[1]->countries as $key => $country)
								@if ($country == $company_type->services[1]->countries->last()) <div id="cloneable"> @endif

									{{ Form::hidden('service_1_country_'.intval($key+1).'_id', $country->pivot->id) }}
									<div class="field-group">												
										<div class="field-container">
											{{ Form::label('service_1_country_'.intval($key+1), 'Bank location')}}
											<div class="custom-input-class-select-container">																				
												{{ Form::select('service_1_country_'.intval($key+1), $countries, $country->pivot->country_id, ['class' => 'custom-input-class service_countries']) }}
											</div>
										</div>		
										<div class="field-container">
											{{ Form::label('service_1_price_eu_'.intval($key+1), 'Account fee €')}}
											{{ Form::text('service_1_price_eu_'.intval($key+1), $country->pivot->price_eu, ['class'=>'custom-input-class service_prices_eu']) }}
										</div>					
										<div class="field-container">
											{{ Form::label('service_1_price_'.intval($key+1), 'Account fee $')}}
											{{ Form::text('service_1_price_'.intval($key+1), $country->pivot->price, ['class'=>'custom-input-class service_prices']) }}
										</div>								
									</div>
								@if ($country == $company_type->services[1]->countries->last()) </div><!-- end cloneable--> @endif							
							@endforeach

							<div class="pasteclone"></div>

							{{ Form::hidden('service_1_count', count($company_type->services[1]->countries), ['id'=>'service_1_count']) }}
						
							<a href="#" class="add-more" data-service="service_1"><button class="custom-submit-class">Add another bank account</button></a>
						@else
							<div id="cloneable">
								<div class="field-group">												
									<div class="field-container">
										{{ Form::label('service_1_country_1', 'Bank location')}}
										<div class="custom-input-class-select-container">																				
											{{ Form::select('service_1_country_1', $countries, null, ['class' => 'custom-input-class service_countries']) }}
										</div>
									</div>		
									<div class="field-container">
										{{ Form::label('service_1_price_eu_1', 'Account fee €')}}
										{{ Form::text('service_1_price_eu_1', null, ['class'=>'custom-input-class service_prices_eu']) }}
									</div>					
									<div class="field-container">
										{{ Form::label('service_1_price_1', 'Account fee $')}}
										{{ Form::text('service_1_price_1', null, ['class'=>'custom-input-class service_prices']) }}
									</div>								
								</div>
							</div>
							<div class="pasteclone"></div>

							{{ Form::hidden('service_1_count', '1', ['id'=>'service_1_count']) }}
							<a href="#" class="add-more" data-service="service_1"><button class="custom-submit-class">Add another bank account</button></a>
						@endif
					</div>
					
					<div class="each-service">
						<h3 class="form-header">Credit/debit cards</h3>						
						{{ Form::hidden('service_2_name', 'Credit/debit cards', ['class'=>'custom-input-class']) }}
						
						@if(count($company_type->services) > 0 && isset($company_type->services[2]))
							{{ Form::hidden('service_2_id', (count($company_type->services) > 0 && isset($company_type->services[2]))  ? $company_type->services[2]->id : '') }}

							@foreach($company_type->services[2]->countries as $key => $country)
								@if ($country == $company_type->services[2]->countries->last()) <div id="cloneable"> @endif
									
									{{ Form::hidden('service_2_country_'.intval($key+1).'_id', $country->pivot->id) }}
									<div class="field-group">												
										<div class="field-container">
											{{ Form::label('service_2_country_'.intval($key+1), 'Bank location')}}
											<div class="custom-input-class-select-container">										
												{{ Form::select('service_2_country_'.intval($key+1), $countries, $country->pivot->country_id, ['class' => 'custom-input-class service_countries']) }}
											</div>
										</div>
										<div class="field-container">
											{{ Form::label('service_2_price_eu_'.intval($key+1), 'Card fee €')}}
											{{ Form::text('service_2_price_eu_'.intval($key+1), $country->pivot->price_eu, ['class'=>'custom-input-class service_prices_eu']) }}
										</div>							
										<div class="field-container">
											{{ Form::label('service_2_price_'.intval($key+1), 'Card fee $')}}
											{{ Form::text('service_2_price_'.intval($key+1), $country->pivot->price, ['class'=>'custom-input-class service_prices']) }}
										</div>									
									</div>
								@if ($country == $company_type->services[2]->countries->last()) </div><!-- end cloneable--> @endif							
							@endforeach

							<div class="pasteclone"></div>

							{{ Form::hidden('service_2_count', count($company_type->services[2]->countries), ['id'=>'service_2_count']) }}
							<a href="#" class="add-more" data-service="service_2"><button class="custom-submit-class">Add another card</button></a>
						@else
							<div id="cloneable">
								<div class="field-group">												
									<div class="field-container">
										{{ Form::label('service_2_country_1', 'Bank location')}}
										<div class="custom-input-class-select-container">										
											{{ Form::select('service_2_country_1', $countries, null, ['class' => 'custom-input-class service_countries']) }}
										</div>
									</div>							
									<div class="field-container">
										{{ Form::label('service_2_price_eu_1', 'Card fee €')}}
										{{ Form::text('service_2_price_eu_1', null, ['class'=>'custom-input-class service_prices_eu']) }}
									</div>
									<div class="field-container">
										{{ Form::label('service_2_price_1', 'Card fee $')}}
										{{ Form::text('service_2_price_1', null, ['class'=>'custom-input-class service_prices']) }}
									</div>								
								</div>
							</div>
							<div class="pasteclone"></div>

							{{ Form::hidden('service_2_count', '1', ['id'=>'service_2_count']) }}
							<a href="#" class="add-more" data-service="service_2"><button class="custom-submit-class">Add another card</button></a>
						@endif
					</div>					

					<!--<div class="each-service">
						<h3 class="form-header">Information services</h3>
						
						@foreach($company_type->informationservices as $key => $informationservice)
							@if ($informationservice == $company_type->informationservices->last()) <div id="cloneable"> @endif
								<div class="field-group">
									<div class="field-container">
										{{ Form::hidden('information_service_'.intval($key+1).'_id', $informationservice->id) }}
										{{ Form::label('information_service_'.intval($key+1), 'Information services name')}}										
										{{ Form::text('information_service_'.intval($key+1), $informationservice->name, ['class'=>'custom-input-class information_services']) }}
									</div>
								</div>
							@if ($informationservice == $company_type->informationservices->last()) </div>@endif
						@endforeach
						<div class="pasteclone"></div>

						{{ Form::hidden('information_service_count', count($company_type->informationservices), ['id'=>'information_service_count']) }}
						<a href="#" class="add-more" data-service="information_service"><button class="custom-submit-class">Add information service</button></a>
					</div>-->
					
					{{ Form::submit('Save', ['class'=>'custom-submit-class']) }}
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
			$lastElAdded.find('input.service_prices').attr('name', serviceName+'_price_'+id).val('');			
			$lastElAdded.find('input.service_prices_eu').attr('name', serviceName+'_price_eu_'+id).val('');			
		}		
	}

	$('.add-more').on('click', function(e){
		e.preventDefault();


		var serviceName = $(this).data('service');

		cloneForm($(this).parent('.each-service').children('#cloneable').find('.field-group'));
		updateClonedFields(serviceName, $(this));
		updateHiddenField(serviceName, $(this));

	});

	$('#edit_company_type').validate({
		rules : {
			'company_type_name': 'required',
			'company_name_rules': 'required',
			'shareholder_name_rules': 'required',
			'director_name_rules': 'required',
			'secretary_name_rules': 'required',
			'company_type_price_eu': 'required',
			'company_type_price': 'required',
			'service_3_price_eu_1': 'required',
			'service_3_price_1': 'required',
			'shareholder_price_eu': 'required',
			'shareholder_price': 'required',
			'director_price_eu': 'required',
			'director_price': 'required',
			'secretary_price_eu': 'required',
			'secretary_price': 'required',
			'service_1_country_1': 'required',
			'service_1_price_eu_1': 'required',
			'service_1_price_1': 'required',
			'service_2_country_1': 'required',
			'service_2_price_eu_1': 'required',
			'service_2_price_1': 'required'
		},
		messages: {
			'company_type_name': 'Please provide company type',
			'company_name_rules': 'Please provide company name rules',
			'shareholder_name_rules': 'Please provide shareholder rules',
			'director_name_rules': 'Please provide director rules',
			'secretary_name_rules': 'Please provide secretary rules',
			'company_type_price_eu': 'Please provide incorporation charge in €',
			'company_type_price': 'Please provide incorporation charge in US$',
			'service_3_price_eu_1': 'Please provide registered office fee in €',
			'service_3_price_1': 'Please provide registered office fee in US$',
			'shareholder_price_eu': 'Please provide shareholder fee in €',
			'shareholder_price': 'Please provide shareholder fee in US$',
			'director_price_eu': 'Please provide director fee in €',
			'director_price': 'Please provide director fee in US$',
			'secretary_price_eu': 'Please provide secretary fee in €',
			'secretary_price': 'Please provide secretary fee in US$',
			'service_1_country_1': 'Please provide bank location',
			'service_1_price_eu_1': 'Please provide bank account fee in €',
			'service_1_price_1': 'Please provide bank account fee in US$',
			'service_2_country_1': 'Please provide bank location for credit card',
			'service_2_price_eu_1': 'Please provide credit card fee in €',
			'service_2_price_1': 'Please provide credit card fee in US$'
		}
	});
</script>
@endsection