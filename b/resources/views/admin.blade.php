@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="space50"></div>
				<h1>OCS website admin dashboard</h1>
				
				<div class="space50"></div>
				<ul class="admin-ctas">
					<li><a href="{{ route('admin.company.index') }}"><button class="custom-submit-class">Shelf companies</button></a></li>							
					<li><a href="{{ route('admin.jurisdiction.index') }}"><button class="custom-submit-class">Company types</button></a></li>						
					<li><a href="{{ route('admin.registeredcompany.index') }}"><button class="custom-submit-class">Pending orders</button></a></li>					
					<li><a href="{{ route('admin.person.index') }}"><button class="custom-submit-class">Person database</button></a></li>						
					<li><a href="{{ route('admin.approvedcompany.index') }}"><button class="custom-submit-class">Company database</button></a></li>						
				</ul>
			</div>
		</div>
	</div>
@endsection