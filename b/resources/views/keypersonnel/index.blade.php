@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<div class="space50"></div>
				<h1>Key Personnel</h1><a href="{{ route('admin.keypersonnel.create') }}">Create new</a>				
				<div class="space50"></div>
								
				<table class="table table-striped"> 
					<thead> 
						<tr><th>#</th><th>Name</th><th>Price</th><th>Role</th><th>Created At</th></tr></thead> 
					<tbody> 
						@if($keypersonnel->count() > 0)
			              	@foreach($keypersonnel as $k => $kp)
			                    <tr>
			                    	<th scope="row">{{ $kp->id }}</th>
			                    	<td>{{ $kp->name }}</td>			                    	
			                    	<td>{{ $kp->price }}</td>			                    	
			                    	<td>{{ $kp->role }}</td>
			                    	<td>{{ $kp->created_at }}</td>
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