@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="space50"></div>
				<h1>Admin panel</h1>
				
				<div class="space50"></div>
				<ul>
					<li><a href="{{ route('admin.jurisdiction.index') }}">Jurisdictions & Company Types</a></li>
					<li><a href="{{ route('admin.company.index') }}">Self Companies</a></li>
					<li><a href="{{ route('admin.service.index') }}">Company Services</a></li>
				</ul>
			</div>
		</div>
	</div>
@endsection