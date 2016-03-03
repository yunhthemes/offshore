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
						<div class="custom-input-class-select-container">
							{{ Form::select('company_type', $company_types, null, ['class'=>'custom-input-class']) }}
						</div>
					</div>					
					<div class="field-container">
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
					</div>					
					{{ Form::submit('Submit', ['class'=>'custom-submit-class']) }}
			{!! Form::close() !!}
			</div>

		</div>
	</div>
</div>
@endsection