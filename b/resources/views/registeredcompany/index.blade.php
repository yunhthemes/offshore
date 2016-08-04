@extends('layouts.master')

@section('content')	
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<div class="space50"></div>
				<h1>Registered Companies</h1>				
				<a href="{{ url('/admin') }}"><button class="custom-submit-class">Return to dashboard</button></a>				
				<div class="space50"></div>
							

				<div id="demo" class="box jplist">
					<!-- data -->
	                <div class="box text-shadow">
						<table class="table table-striped demo-tbl custom-table-2"> 
							<thead class="jplist-panel">

								<tr data-control-type="sort-buttons-group"
	                                data-control-name="header-sort-buttons"
	                                data-control-action="sort"
	                                data-mode="single"
	                                data-datetime-format="{month}/{day}/{year}">

									<th>
										<span class="header sortable-header">Code</span>
										<span class="sort-btns">
	                                        <i class="fa fa-caret-up" data-path=".code" data-type="text" data-order="asc" title="Sort by Code Asc"></i>
	                                        <i class="fa fa-caret-down" data-path=".code" data-type="text" data-order="desc" title="Sort by Code Desc"></i>
	                                    </span>
									</th>
									<th>
										<span class="header sortable-header">Company name</span>
										<span class="sort-btns">
	                                        <i class="fa fa-caret-up" data-path=".name" data-type="text" data-order="asc" title="Sort by Name Asc"></i>
	                                        <i class="fa fa-caret-down" data-path=".name" data-type="text" data-order="desc" title="Sort by Name Desc"></i>
	                                    </span>
									</th>
									<th>
										<span class="header sortable-header">Company type</span>
										<span class="sort-btns">
	                                        <i class="fa fa-caret-up" data-path=".companytype" data-type="text" data-order="asc" title="Sort by Company Type Asc"></i>
	                                        <i class="fa fa-caret-down" data-path=".companytype" data-type="text" data-order="desc" title="Sort by Company Type Desc"></i>
	                                    </span>
									</th>
									<th>
										<span class="header sortable-header">Incorporated</span>
										<span class="sort-btns">
	                                        <i class="fa fa-caret-up" data-path=".date" data-type="datetime" data-order="asc" title="Sort by Date Asc"></i>
	                                        <i class="fa fa-caret-down" data-path=".date" data-type="datetime" data-order="desc" title="Sort by Date Desc"></i>
	                                    </span>
									</th>																	
									<th>
										<span class="header sortable-header">Registered By</span>
										<span class="sort-btns">
	                                        <i class="fa fa-caret-up" data-path=".username" data-type="text" data-order="asc" title="Sort by Name Asc"></i>
	                                        <i class="fa fa-caret-down" data-path=".username" data-type="text" data-order="desc" title="Sort by Name Desc"></i>
	                                    </span>
									</th>								
									<th><span class="header">Action</span></th>								
								</tr>

							</thead> 
							<tbody id="table-content"> 
								@if($companies->count() > 0)							
					              	@foreach($companies as $k => $company)
					                    <tr id="id-{{$company->id}}" class="company-id tbl-item">
					                    	<td class="code">
					                    		@if($company->code)
					                    			{{ $company->code }}
					                    		@else
					                    			{{ "New Inc" }}
					                    		@endif
				                    		</td>
					                    	<td class="name">{{ $company->name }}</td>
					                    	<td class="companytype">{{ $company->companytypes->name }}</td>
					                    	<td><span class="date">{{ date('d M Y', strtotime($company->incorporation_date)) }}</span></td>
					                    	<td class="username">
					                    		@if($company->wpusers->count() > 0)													
													@foreach($company->wpusers as $key => $company_wpuser)
														@if($key>0),@endif
														{{ $company_wpuser->display_name }}
													@endforeach
					                    	 	@else 
					                    	 		{{ "New" }}
					                    	 	@endif
				                    	 	</td>
				                    	 	<td><a href="{{ route('admin.registeredcompany.show', $company->id) }}"><button class="custom-submit-class">View</button></a></td>		                    						
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
		</div>
	</div>
	<script>
		$(document).ready(function(){
			// jplist plugin call
		    $('#demo').jplist({
		        itemsBox: '.demo-tbl',
				itemPath: '.tbl-item',
				panelPath: '.jplist-panel',
				// storage: 'localstorage',
				// storageName: 'jplist-table-sortable-cols'
		    });

	        //alternate up / down buttons on header click
		    $('.demo-tbl .header').on('click', function () {
		        $(this).next('.sort-btns').find('[data-path]:not(.jplist-selected):first').trigger('click');
		    });
		});
	</script>
@endsection