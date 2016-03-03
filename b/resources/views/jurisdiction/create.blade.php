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
						{{ Form::text('company_type_name', null, ['class'=>'custom-input-class','placeholder'=>'Jurisdiction and company type']) }}
					</div>
					<div class="field-container">
						{{ Form::text('company_type_price', null, ['class'=>'custom-input-class','placeholder'=>'Price']) }}					
					</div>
					<!-- <div class="field-container">
						{{ Form::text('company_name', null, ['class'=>'custom-input-class','placeholder'=>'Company name']) }}
					</div>
					<div class="field-container">
						{{ Form::text('company_incorporation_date', null, ['class'=>'custom-input-class','placeholder'=>'Company incorporation date']) }}
					</div>
					<div class="field-container">
						{{ Form::text('company_price', null, ['class'=>'custom-input-class','placeholder'=>'Company price']) }}					
					</div>
					<div class="field-container">
						{{ Form::checkbox('shelf_company', '1') }}
						{{ Form::label('shelf_company', 'Shelf Company?') }}
					</div> -->
					<div class="field-container">
						{{ Form::text('service_name', null, ['class'=>'custom-input-class','placeholder'=>'Service name']) }}
					</div>
					<div class="field-container">
						{{ Form::text('service_price', null, ['class'=>'custom-input-class','placeholder'=>'Service price']) }}
					</div>
					{{ Form::submit('Submit', ['class'=>'custom-submit-class']) }}
			{!! Form::close() !!}
			</div>

		</div>
	</div>
</div>
@endsection