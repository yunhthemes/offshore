@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="space50"></div>
				<h1>Admin panel</h1>
				
				<div class="space50"></div>
				<ul class="admin-ctas">
					<li><a href="{{ route('admin.jurisdiction.index') }}"><button class="custom-submit-class">Jurisdictions</button></a></li>
					<li><a href="{{ route('admin.service.index') }}"><button class="custom-submit-class">Services</button></a></li>
					<li><a href="{{ route('admin.keypersonnel.index') }}"><button class="custom-submit-class">Key Personnel</button></a></li>					
					<li><a href="{{ route('admin.company.index') }}"><button class="custom-submit-class">Self Companies</button></a></li>					
				</ul>
			</div>
		</div>
	</div>
@endsection