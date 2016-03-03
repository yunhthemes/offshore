@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<div class="space50"></div>
				<h1>Companies</h1><a href="{{ route('admin.company.create') }}">Create new</a>				
				<div class="space50"></div>
								
				<table class="table table-striped"> 
					<thead> 
						<tr><th>#</th><th>Name</th><th>Incorporation Date</th><th>Price</th><th>Shelf Company</th><th>Company Type</th><th>Created At</th></tr></thead> 
					<tbody> 
						@if($companies->count() > 0)
			              	@foreach($companies as $k => $company)
			                    <tr>
			                    	<th scope="row">{{ $company->id }}</th>
			                    	<td>{{ $company->name }}</td>
			                    	<td>{{ $company->incorporation_date }}</td>
			                    	<td>{{ $company->price }}</td>
			                    	<td>@if($company->shelf==1){{ 'yes' }}@else{{ 'no' }}@endif</td>
			                    	<td>{{ $company->companytypes->name }}</td>
			                    	<td>{{ $company->created_at }}</td>
			                    </tr> 
			              	@endforeach
			            @else					
							<tr><th scope="row"><p>No list to display!</p></th></tr>
			            @endif						
					</tbody> 
				</table>
				
			</div>
		</div>
	</div>
@endsection