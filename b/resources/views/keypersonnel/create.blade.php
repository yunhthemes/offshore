@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="space50"></div>
				<h1>Add new key personnel</h1>
				<a href="{{ route('admin.keypersonnel.index') }}">Back</a>
					
				<div class="space50"></div>
				
				<div class="form-container">
					{!! Form::open(array('route' => 'admin.keypersonnel.store')) !!}					
						<div class="field-container">
							{{ Form::text('keypersonnel_name', null, ['class'=>'custom-input-class','placeholder'=>'Key personnel name']) }}
							
						</div>
						<div class="field-container">
							{{ Form::text('keypersonnel_price', null, ['class'=>'custom-input-class','placeholder'=>'Key personnel price']) }}
						</div>
						<div class="field-container">
							{{ Form::text('keypersonnel_role', null, ['class'=>'custom-input-class','placeholder'=>'Key personnel role']) }}
						</div>						
						<div class="field-container">
							{{ Form::text('keypersonnel_passport', null, ['class'=>'custom-input-class','placeholder'=>'Key personnel passport']) }}
						</div>						
						<div class="field-container">
							{{ Form::text('keypersonnel_utility_bill', null, ['class'=>'custom-input-class','placeholder'=>'Key personnel utility bill']) }}
						</div>						
						
						{{ Form::submit('Submit', ['class'=>'custom-submit-class']) }}
				{{ Form::close() }}
				</div>

			</div>
		</div>
	</div>
@endsection