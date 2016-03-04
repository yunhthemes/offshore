@extends('layouts.master')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="space50"></div>
			<h1>Add new service</h1>
			<a href="{{ route('admin.service.index') }}">Back</a>
				
			<div class="space50"></div>
			
			<div class="form-container">
				{!! Form::open(array('route' => 'admin.service.store')) !!}					
					<div class="field-container">
						{{ Form::text('service_name', null, ['class'=>'custom-input-class','placeholder'=>'Service name']) }}
					</div>
					<div id="cloneable">
						<div class="field-group">
							<div class="field-container">
								<div class="custom-input-class-select-container">
									{{ Form::select('company_type_id_1', $company_types, null, ['class'=>'custom-input-class company_types']) }}
								</div>
							</div>
							<div class="field-container">
								{{ Form::text('service_price_1', null, ['class'=>'custom-input-class service_prices','placeholder'=>'Service price']) }}				
							</div>
						</div>
					</div>
					<div class="pasteclone"></div>		
					<a href="#" class="add-more">Add More  <i class="fa fa-plus"></i></a>
					{{ Form::hidden('company_type_count', '1', ['id'=>'company_type_count']) }}
					{{ Form::submit('Submit', ['class'=>'custom-submit-class']) }}

			{{ Form::close() }}
			</div>

		</div>
	</div>
</div>

<script>
	function cloneForm($el) {
		$el.clone().appendTo('.pasteclone');
	}
	function updateHiddenField() {		
		$('#company_type_count').val($('.company_types').length);
	}
	function updateClonedFields() {
		var id = parseInt($('.pasteclone').find('.field-group').length) + 1;

		var $lastElAdded = $('.pasteclone').find('.field-group').last();

		$lastElAdded.find('select').attr('name', 'company_type_id_'+id).val('');
		$lastElAdded.find('input').attr('name', 'service_price_'+id).val('');
		
	}

	$('.add-more').on('click', function(e){
		e.preventDefault();

		cloneForm($('#cloneable').find('.field-group'));
		updateClonedFields();
		updateHiddenField();

	});
</script>
@endsection