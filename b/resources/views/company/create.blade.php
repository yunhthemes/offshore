@extends('layouts.master')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="space50"></div>
			<h1>Add new company</h1>
			<a href="{{ route('admin.company.index') }}">Back</a>
				
			<div class="space50"></div>
			
			<div class="form-container">
				{!! Form::open(array('route' => 'admin.company.store')) !!}
					<div class="field-container">
						{{ Form::label('company_type', 'Jurisdiction/Company type')}}
						<div class="custom-input-class-select-container">
							{{ Form::select('company_type', $company_types, null, ['class'=>'custom-input-class']) }}
						</div>
					</div>					
					<div class="field-container">
						{{ Form::label('company_name', 'Company name')}}
						{{ Form::text('company_name', null, ['class'=>'custom-input-class']) }}
					</div>
					<div class="field-container">
						{{ Form::label('company_incorporation_date', 'Incorporation date')}}
						{{ Form::text('company_incorporation_date', null, ['class'=>'custom-input-class']) }}
					</div>
					<div class="field-container">
						{{ Form::label('company_price', 'Price (USD)')}}
						{{ Form::text('company_price', null, ['class'=>'custom-input-class']) }}
					</div>					
					<div class="field-container">
						{{ Form::label('company_price_eu', 'Price (EUR)')}}
						{{ Form::text('company_price_eu', null, ['class'=>'custom-input-class']) }}
					</div>					

					{{ Form::submit('Submit', ['class'=>'custom-submit-class']) }}
			{!! Form::close() !!}
			</div>

		</div>
	</div>
</div>

<script>
	$(document).ready(function(){

		function populate_fields(index, shareholder_id) {		
			$('.populate-shareholder-fields').append('<div class="field-container"><input type="text" name="shareholder_'+shareholder_id+'_share_amount" placeholder="Shareholder '+(parseInt(index)+1)+' share amount" class="custom-input-class" /></div>')
		}

		$('#shareholder').on('change', function(e){
			var shareholder_ids_arr = $(this).val();
			
			$('.populate-shareholder-fields').html('');
			$.each(shareholder_ids_arr, function(index, shareholder_id){
				populate_fields(index, shareholder_id);
			});
		});
	});
</script>

@endsection