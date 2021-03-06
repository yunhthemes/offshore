@extends('layouts.master')

@section('content')	
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<div class="space50"></div>
				<h1>Pending orders</h1>				
				<a href="{{ url('/admin') }}"><button class="custom-submit-class">Return to dashboard</button></a>				
				<div class="space10"></div>									

				<div id="demo" class="box jplist">
					
					<div class="jplist-panel box panel-top">
						<div class="search-container">							
						   	<input 
							  data-path="*" 
							  type="text" 
							  value="" 
							  placeholder="Search..." 
							  data-control-type="textbox" 
							  data-control-name="title-filter" 
							  data-control-action="filter"
						   	/>							
						</div>
						<table class="table table-striped custom-table-2"> 							
							<!-- panel -->
							<thead>						
								<!-- search any text in the element -->

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
										<span class="header sortable-header">Jurisdiction</span>
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
										<span class="header sortable-header">Registered</span>
										<span class="sort-btns">
	                                        <i class="fa fa-caret-up" data-path=".username" data-type="text" data-order="asc" title="Sort by Name Asc"></i>
	                                        <i class="fa fa-caret-down" data-path=".username" data-type="text" data-order="desc" title="Sort by Name Desc"></i>
	                                    </span>
									</th>								
									<th><span class="header">Action</span></th>							
								</tr>													
							</thead>				 
							
							<!-- data -->  
							<tbody id="table-content" class="list box text-shadow"> 

								@if($companies->count() > 0)							
					              	@foreach($companies as $k => $company)
					                    <tr id="id-{{$company->id}}" class="company-id list-item box">
					                    	<td class="code">
					                    		@if($company->code)
					                    			{{ $company->code }}
					                    		@else
					                    			{{ "New Inc" }}
					                    		@endif
				                    		</td>
					                    	<td class="name">{{ $company->name }}</td>
					                    	<td class="companytype">{{ $company->companytypes->name }}</td>
					                    	<td>
					                    		<span class="date">					 		
					                    		@if(strtotime($company->incorporation_date) <= 0)
					                    			TBC
					                    		@else
													{{ date('d M Y', strtotime($company->incorporation_date)) }}</span>
					                    		@endif
					                    		</span>
					                    	</td>
					                    	<td class="username">
												@foreach($company->wpusers as $key => $company_wpuser)		
													@if($company_wpuser->pivot->status == 2)	
													<?php
													$field = App\WpBpXprofileFields::where('name', 'First name')->first();
													$firstname = App\WpBpXprofileData::where('user_id', $company_wpuser->ID)->where('field_id', $field->id)->first();
													?>
													{{ (count($firstname) == 0) ? "" : $firstname->value }}
													<?php
													$field = App\WpBpXprofileFields::where('name', 'Surname')->first();
													$lastname = App\WpBpXprofileData::where('user_id', $company_wpuser->ID)->where('field_id', $field->id)->first();
													?>
													{{ (count($lastname) == 0) ? "" : " ".$lastname->value }}
													@endif
												@endforeach
				                    	 	</td>
				                    	 	<td><a href="{{ route('admin.registeredcompany.show', $company->id) }}"><button class="custom-submit-class">View</button></a><a href="{{ route('admin.registeredcompany.edit', $company->id) }}"><button class="custom-submit-class">Edit</button></a></td>		                    						
					                    </tr> 
					              	@endforeach			              	
					            @else					
									<tr><th scope="row"><p>No list to display!</p></th></tr>
					            @endif

							</tbody>
							
							<div class="box jplist-no-results text-shadow align-center">
								<p>No results found</p>
							</div>

						</table>
					</div>
								
				</div>				
				
				<div class="space50"></div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			// jplist plugin call
		    $('#demo').jplist({
		        itemsBox: '.list',
				itemPath: '.list-item',
				panelPath: '.jplist-panel',
				// storage: 'localstorage',
				// storageName: 'jplist-table-sortable-cols'
		    });

	        //alternate up / down buttons on header click
		    $('.header').on('click', function () {
		        $(this).next('.sort-btns').find('[data-path]:not(.jplist-selected):first').trigger('click');
		    });
		});
	</script>
@endsection