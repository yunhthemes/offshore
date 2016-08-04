@extends("layouts.master")

@section("content")
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="space50"></div>
				<h1>Registered Company</h1>				
				<a href="{{ route('admin.registeredcompany.index') }}"><button class="custom-submit-class">Return to registered companies</button></a>				
				
				<div class="space50"></div>
				<div class="labels">
					<div class="row">
						<div class="col-md-4"><p>Company name</p></div>	
						<div class="col-md-8"><p>{{ $company->name }}</p></div>	
					</div>
					<div class="row">
						<div class="col-md-4"><p>Type</p></div>
						<div class="col-md-8">
							@if($company->shelf == 0)
								<p>{{ "New" }}</p>
			            	@else
								<p>{{ "Shelf" }}</p>
			            	@endif
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">Registered by</div>
						<div class="col-md-8"><p>{{ $company->wpusers[0]->display_name }}</p></div>
					</div>
					<div class="row">
						<div class="col-md-4"><p>Jurisdiction</p></div>
						<div class="col-md-8"><p>{{ $company->companytypes->name }}</p></div>
					</div>
					<div class="row">
						<div class="col-md-4"><p>Directors</p></div>
						<div class="col-md-8">
							@if($company->wpusers[0]->pivot->nominee_director==1)
        						<p>{{ "Offshore Company Solutions to provide nominee directors" }}</p>
        					@endif
							<table class="table table-striped">
	                    		@foreach($company->companywpuser_directors as $director)
	                    			<tr>
	                    				<th>Type</th>
	                    				<th>Name</th>
	                    				<th>Address</th>
	                    				<th>Address 2</th>
	                    				<th>Address 3</th>
	                    				<th>Address 4</th>
	                    				<th>Telephone</th>
	                    				<th>Passport</th>
	                    				<th>Bill</th>	                    				
	                    			</tr>
	                    			<tr>
	                    				@if($director->type==1)
	                    				<td>{{ "Individual" }}</td>
	                    				@else
										<td>{{ "Company" }}</td>
	                    				@endif
	                    				<td>{{ $director->name }}</td>
	                    				<td>{{ $director->address }}</td>
	                    				<td>{{ $director->address_2 }}</td>
	                    				<td>{{ $director->address_3 }}</td>
	                    				<td>{{ $director->address_4 }}</td>
	                    				<td>{{ $director->telephone }}</td>
	                    				<td><a href="{{ public_path('uploads') . '/' . $company->wpusers[0]->nice_name . '/' . $director->passport }}">{{ $director->passport }}</a></td>
	                    				<td><a href="{{ url('public/uploads/'.$company->wpusers[0]->user_nicename.'/'.$director->bill) }}">{{ $director->bill }}</a></td>
	                    			</tr>
	                    		@endforeach
                    		</table>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4"><p>Shareholders</p></div>
						<div class="col-md-8">
							@if($company->wpusers[0]->pivot->nominee_shareholder==1)
        						<p>{{ "Offshore Company Solutions to provide nominee shareholders" }}</p>
        					@endif
							<table class="table table-striped">
	                    		@foreach($company->companywpuser_shareholders as $shareholder)
	                    			<tr>
	                    				<th>Type</th>
	                    				<th>Name</th>
	                    				<th>Address</th>
	                    				<th>Address 2</th>
	                    				<th>Address 3</th>
	                    				<th>Address 4</th>
	                    				<th>Telephone</th>
	                    				<th>Passport</th>
	                    				<th>Bill</th>			                    			
	                    				<th>Share amount</th>			                			
	                    			</tr>
	                    			<tr>
	                    				@if($shareholder->type==1)
	                    				<td>{{ "Individual" }}</td>
	                    				@else
										<td>{{ "Company" }}</td>
	                    				@endif
	                    				<td>{{ $shareholder->name }}</td>
	                    				<td>{{ $shareholder->address }}</td>
	                    				<td>{{ $shareholder->address_2 }}</td>
	                    				<td>{{ $shareholder->address_3 }}</td>
	                    				<td>{{ $shareholder->address_4 }}</td>
	                    				<td>{{ $shareholder->telephone }}</td>
	                    				<td><a href="{{ url('public/uploads/'.$company->wpusers[0]->user_nicename.'/'.$shareholder->passport) }}">{{ $shareholder->passport }}</a></td>
	                    				<td><a href="{{ url('public/uploads/'.$company->wpusers[0]->user_nicename.'/'.$shareholder->bill) }}">{{ $shareholder->bill }}</a></td>
	                    				<td>{{ $shareholder->share_amount }}</td>	                    
	                    			</tr>
	                    		@endforeach
                    		</table>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<p>Secretaries</p>
						</div>
						<div class="col-md-8">
							@if($company->wpusers[0]->pivot->nominee_secretary==1)
        						<p>{{ "Offshore Company Solutions to provide a company secretary" }}</p><br>
        					@endif
							<table class="table table-striped">
	                    		@foreach($company->companywpuser_secretaries as $secretary)
	                    			<tr>
	                    				<th>Type</th>
	                    				<th>Name</th>
	                    				<th>Address</th>
	                    				<th>Address 2</th>
	                    				<th>Address 3</th>
	                    				<th>Address 4</th>
	                    				<th>Telephone</th>
	                    				<th>Passport</th>
	                    				<th>Bill</th>
	                    			</tr>
	                    			<tr>
	                    				@if($secretary->type==1)
	                    					<td>{{ "Individual" }}</td>
	                    				@else
											<td>{{ "Company" }}</td>
	                    				@endif
	                    				<td>{{ $secretary->name }}</td>
	                    				<td>{{ $secretary->address }}</td>
	                    				<td>{{ $secretary->address_2 }}</td>
	                    				<td>{{ $secretary->address_3 }}</td>
	                    				<td>{{ $secretary->address_4 }}</td>
	                    				<td>{{ $secretary->telephone }}</td>
	                    				<td><a href="{{ url('public/uploads/'.$company->wpusers[0]->user_nicename.'/'.$secretary->passport) }}">{{ $secretary->passport }}</a></td>
	                    				<td><a href="{{ url('public/uploads/'.$company->wpusers[0]->user_nicename.'/'.$secretary->bill) }}">{{ $secretary->bill }}</a></td>
	                    			</tr>
	                    		@endforeach
                    		</table>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<p>Services</p>
						</div>
						<div class="col-md-8">
							<table class="table table-striped">
	                    		@foreach($servicescountries as $servicecountry)	                    	
                    				<tr>
                    					<td>{{ $servicecountry->service_name }}</td>
                    					@if($servicecountry->service_name!=="Registered office annual fee (compulsory)")
                    					<td>{{ $servicecountry->country_name }}</td>
                    					@endif
                    					<td>{{ ($servicecountry->pivot->credit_card_count==0) ? "" : $servicecountry->pivot->credit_card_count }}</td>
                    				</tr>
	                    		@endforeach
                    		</table>
						</div>
					</div>			
					<div class="row">
						<div class="col-md-4">
							<p>Infomation services</p>
						</div>
						<div class="col-md-8">
							<table class="table table-striped">
	                    		@foreach($informationservices as $informationservice)	
	                    			<tr>
	                    				<td>{{ $informationservice->name }}</td>
	                    			</tr>
	                    		@endforeach
                    		</table>
						</div>
					</div>												
				</div>
			</div>
		</div>
	</div>
@endsection