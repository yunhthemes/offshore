@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="space50"></div>
				<h1>Company types</h1><a href="{{ route('admin.jurisdiction.create') }}"><button class="custom-submit-class">Add a company type</button></a>
				<a href="{{ url('/admin') }}"><button class="custom-submit-class">Return to dashboard</button></a>				
				<div class="space50"></div>
								
				<table class="table table-striped"> 
					<thead> 
						<tr><th>Name</th></tr></thead> 
					<tbody> 
						@if($company_types->count() > 0)
			              	@foreach($company_types as $k => $company_type)
			                    <tr>
			                    	<!-- <th scope="row"><a href="{{ route('admin.jurisdiction.show', $company_type->id) }}">{{ $company_type->id }}</a></th> -->
			                    	<td><a href="{{ route('admin.jurisdiction.show', $company_type->id) }}">{{ $company_type->name }}</a></td>
			                    	<!-- <td><a href="{{ route('admin.jurisdiction.show', $company_type->id) }}">{{ $company_type->created_at }}</a></td> -->
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