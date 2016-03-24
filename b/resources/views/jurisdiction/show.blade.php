@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="space50"></div>
				<h1>Jurisdictions</h1><a href="{{ route('admin.jurisdiction.create') }}">Create new</a>
				
				<div class="space50"></div>
				<div class="table-responsive">
					<table class="table table-striped"> 
						<thead> 
							<tr>
								<th>Jurisdiction/Company Type</th>							
								<th>Directors</th>							
								<th>Share holders</th>							
								<th>Secretaries</th>							
								<th>Services</th>							
								<th>Infomation Services</th>							
							</tr>
						</thead> 
						<tbody> 
							
		                    <tr>			                    	
		                    	<td>{{ $company_type->name }}</td>
		                    	<td>
		                    		<table class="table table-striped">
		                    		@foreach($company_type->directors as $director)
		                    			<tr><th>Rules</th><th>Price</th></tr>
		                    			<tr><td>{{ $director->name_rules }}</td><td>{{ $director->price }}</td></tr>
		                    		@endforeach
		                    		</table>
		                    	</td>
		                    	<td>
		                    		<table class="table table-striped">
		                    		@foreach($company_type->shareholders as $shareholder)
		                    			<tr><th>Rules</th><th>Price</th></tr>
		                    			<tr><td>{{ $shareholder->name_rules }}</td><td>{{ $shareholder->price }}</td></tr>
		                    		@endforeach
		                    		</table>
		                    	</td>
		                    	<td>
		                    		<table class="table table-striped">
		                    		@foreach($company_type->secretaries as $secretary)
		                    			<tr><th>Rules</th><th>Price</th></tr>
		                    			<tr><td>{{ $secretary->name_rules }}</td><td>{{ $secretary->price }}</td></tr>
		                    		@endforeach
		                    		</table>
		                    	</td>
		                    	<td>
		                    		<table class="table table-striped">
		                    		@foreach($company_type->services as $service)
		                    			<tr><th>Name</th><th>Country</th><th>Price</th></tr>
		                    			@foreach($service->countries as $country)
		                    				<tr><td>{{ $service->name }}</td><td>{{ $country->name }}</td><td>{{ $country->pivot->price }}</td></tr>
		                    			@endforeach
		                    		@endforeach
		                    		</table>
		                    	</td>
		                    	<td>
		                    		<table class="table table-striped">
		                    		@foreach($company_type->informationservices as $informationservice)
		                    			<tr><th>Name</th></tr>
		                    			<tr><td>{{ $informationservice->name }}</td></tr>
		                    		@endforeach
		                    		</table>
		                    	</td>
		                    	
		                    </tr> 
				              		
						</tbody> 
					</table>
				</div>				
			</div>
		</div>
	</div>
@endsection