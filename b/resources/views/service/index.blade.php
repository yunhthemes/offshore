@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<div class="space50"></div>
				<h1>Services</h1><a href="{{ route('admin.service.create') }}">Create new</a>				
				<div class="space50"></div>
								
				<table class="table table-striped"> 
					<thead> 
						<tr><th>#</th><th>Name</th><th>Price</th><th>Company Type</th><th>Created At</th></tr></thead> 
					<tbody> 
						@if($services->count() > 0)
			              	@foreach($services as $k => $service)
			                    <tr>
			                    	<th scope="row">{{ $service->id }}</th>
			                    	<td>{{ $service->name }}</td>			                    	
			                    	<td>{{ $service->companytypes[0]->pivot->price }}</td>			                    	
			                    	<td>{{ $service->companytypes[0]->name }}</td>
			                    	<td>{{ $service->created_at }}</td>
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