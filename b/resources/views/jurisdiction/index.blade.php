@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="space50"></div>
				<h1>Jurisdictions</h1><a href="{{ route('admin.jurisdiction.create') }}">Create new</a>
				
				<div class="space50"></div>
								
				<table class="table table-striped"> 
					<thead> 
						<tr><th>#</th><th>Name</th><th>Created At</th></tr></thead> 
					<tbody> 
						@if($company_types->count() > 0)
			              	@foreach($company_types as $k => $company_type)
			                    <tr>
			                    	<th scope="row">{{ $company_type->id }}</th>
			                    	<td>{{ $company_type->name }}</td>
			                    	<td>{{ $company_type->created_at }}</td>
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