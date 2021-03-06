@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8">				
				<div class="space50"></div>
				<h1>Edit company record</h1>				
				<a href="{{ route('admin.approvedcompany.index') }}"><button class="custom-submit-class">Return to company details</button></a>

				{{ Form::open([ 'route' => ['admin.approvedcompany.update', $company->id ], 'method' => 'put', 'id' => 'edit_registered_company' ]) }}	
					<div class="space50"></div>
					<div class="labels">
						<div class="row">
							<div class="col-md-4"><p>Company status</p></div>
							<div class="col-md-8">
								<?php 
								if($company->wpusers[0]->pivot->status == 1)
									$company_status = "Pending"; 
								elseif($company->wpusers[0]->pivot->status == 2)
									$company_status = "Approved"; 
								else
									$company_status = "Rejected"; 
								?>
								<p>{{ $company_status }}</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Company code</p></div>
							<div class="col-md-8">
								<input type="text" name="company_code" value="{{ $company->code }}">
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Company name</p></div>	
							<div class="col-md-8">
								<input type="text" name="company_name" value="{{ $company->name }}">
							</div>	
						</div>	
						<div class="row each-director">
							<div class="col-md-4">User</div>
							<div class="col-md-8">
								<fieldset>
									<legend>
										<p>
											<?php 
											$field = App\WpBpXprofileFields::where('name', 'First name')->first();
											$firstname = App\WpBpXprofileData::where('user_id', $company->wpusers[0]->ID)->where('field_id', $field->id)->first(); ?>
											{{ (count($firstname) == 0) ? "" : " ".$firstname->value }}
											<?php 
											$field = App\WpBpXprofileFields::where('name', 'Surname')->first();
											$lastname = App\WpBpXprofileData::where('user_id', $company->wpusers[0]->ID)->where('field_id', $field->id)->first(); ?>
											{{ (count($lastname) == 0) ? "" : " ".$lastname->value }}
										</p>
									</legend>
									<input type="hidden" name="wpuser_id" class="person" value="{{ $company->wpusers[0]->ID }}">
									<input type="hidden" name="companywpuser_id" class="person" value="{{ $company->wpusers[0]->pivot->id }}">
									<div class="each-input">
		        						<label for="user_person_code">Person code</label>
		        						<input type="text" name="user_person_code" id="user_person_code" value="{{ $company->wpusers[0]->pivot->owner_person_code }}" class="person">	
			        				</div>
									{{-- <div class="each-input">
			        					<button type="button" class="add-user-to-person custom-submit-class custom-submit-class-2">Add to person database</button>
			        				</div>	 --}}
								</fieldset>
								
							</div>
						</div>		
						<div class="row">
							<div class="col-md-4">Jurisdiction</div>
							<div class="col-md-8"><p>{{ $company->companytypes->jurisdiction }}</p></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Company Type</p></div>
							<div class="col-md-8"><p>{{ $company->companytypes->name }}</p></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Company registration number</p></div>
							<div class="col-md-8">
								<input type="text" name="reg_no" value="{{ $companywpuser->reg_no }}">
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Company tax number</p></div>
							<div class="col-md-8">
								<input type="text" name="tax_no" value="{{ $companywpuser->tax_no }}">
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>VAT registration number</p></div>
							<div class="col-md-8">
								<input type="text" name="vat_reg_no" value="{{ $companywpuser->vat_reg_no }}">
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Incorporation Date</p></div>
							<div class="col-md-8">
								<input type="text" name="incorporation_date" id="incorporation_date" value="{{ (strtotime($company->incorporation_date) <= 0) ? $company->incorporation_date : date('d M Y', strtotime($company->incorporation_date)) }}">
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Registered office</p></div>
							<div class="col-md-8">
								<input type="text" name="reg_office" value="{{ $companywpuser->reg_office }}">
							</div>
						</div>
				
						<div class="row">
							<div class="col-md-4"><p>Shareholders</p></div>
							<div class="col-md-8">								
	        					@if(count($company->companywpuser_shareholders) > 0)
		        					@foreach($company->companywpuser_shareholders as $key => $shareholder)
			        					<div class="row each-director">
			        						<div class="col-md-12">
			        							<fieldset>
				        							<legend>Shareholder {{ $key+1 }}</legend>	
				        							<input type="hidden" name="prefix" value="shareholder_{{ $key+1 }}" class="person">
				        							<input type="hidden" name="shareholder_{{ $key+1 }}_companywpuser_shareholder_id" value="{{ $shareholder->id }}" class="person">
				        							<input type="hidden" name="shareholder_{{ $key+1 }}_person_role" value="shareholder" class="person">

				        							<div class="each-input">
						        						<label for="shareholder_{{ $key+1 }}_type">Type</label>						        	
						        						@if($shareholder->type==1)
															<span>{{ "Individual" }}</span>
						        						@else
															<span>{{ "Company" }}</span>
						        						@endif
						        						<input type="hidden" name="shareholder_{{ $key+1 }}_type" id="shareholder_{{ $key+1 }}_type" value="{{ $shareholder->type }}">
							        				</div>
							        				<div class="each-input">
						        						<label for="shareholder_{{ $key+1 }}_name">Name/Beneficial</label>
						        						<input type="text" name="shareholder_{{ $key+1 }}_name" class="person" value="{{ $shareholder->name }}">
							        				</div>							        	
				        							<div class="each-input">
				        								<label for="shareholder_{{ $key+1 }}_person_code">Person code</label>
				        								<input type="text" name="shareholder_{{ $key+1 }}_person_code" class="shareholder person" value="{{ $shareholder->person_code }}" >
				        							</div>
				        							{{-- <div class="each-input">
							        					<button type="button" class="add-to-person custom-submit-class custom-submit-class-2">Add to person database</button>
							        				</div> --}}						        	
				        							<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_shareholder">Nominee shareholder selected</label>
							        					@if($company->wpusers[0]->pivot->nominee_shareholder==1)
															<span>Yes</span>
														@else
															<span>No</span>
								        				@endif
							        				</div>
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_shareholder">Shareholder</label>
							        					<input type="text" name="shareholder_{{ $key+1 }}_shareholder" class="nominee_shareholder" value="{{ $shareholder->shareholder }}">
							        				</div>
							        				<input type="hidden" name="shareholder_{{ $key+1 }}_beneficial" value="{{ $shareholder->name }}">
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_share_amount">Share amount</label>
							        					<input type="text" class="person" name="shareholder_{{ $key+1 }}_share_amount" value="{{ $shareholder->share_amount }}">
							        				</div>				        				
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_address">Address (Street)</label>
							        					<input type="text" class="person" name="shareholder_{{ $key+1 }}_address" value="{{ $shareholder->address }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_address_2">Address 2 (City)</label>
							        					<input type="text" class="person" name="shareholder_{{ $key+1 }}_address_2" value="{{ $shareholder->address_2 }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_address_3">Address 3 (State)</label>
							        					<input type="text" class="person" name="shareholder_{{ $key+1 }}_address_3" value="{{ $shareholder->address_3 }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_address_4">Address 4 (Country)</label>
							        					<?php $keyplus = $key+1; $name = 'shareholder_'.$keyplus.'_address_4'; ?>
							        					{!! Form::select($name, $countryList, $shareholder->address_4) !!}		
							        				</div>
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_telephone">Telephone</label>
							        					<input type="text" class="person" name="shareholder_{{ $key+1 }}_telephone" value="{{ $shareholder->telephone }}">
							        				</div>
							        				<div class="each-input upload-btn-container">
							        					<label for="shareholder_{{ $key+1 }}_passport">Passport</label>
							        					<input type="hidden" class="person" name="shareholder_{{ $key+1 }}_passport" value="{{ $shareholder->passport }}" />
							                            <span class="btn fileinput-button">
							                                <button class="upload-passport-btn custom-submit-class custom-submit-class-2" data-btn-text="Passport uploaded">Upload passport</button>
							                                <!-- The file input field used as target for the file upload widget -->
							                                <input class="passport_upload" type="file" name="files" data-fieldname="shareholder_{{ $key+1 }}_passport" data-selector="shareholder_{{ $key+1 }}" />
							                            </span>
							                            <!-- The container for the uploaded files -->
							                            <div id="shareholder_{{ $key+1 }}_passport_files" class="files"><p>{{ $shareholder->passport }}</p></div>
							        				</div>
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_bill">Bill</label>
							        					<input type="hidden" class="person" name="shareholder_{{ $key+1 }}_bill" value="{{ $shareholder->bill }}" />
														<span class="btn fileinput-button">            
							                                <button class="upload-bill-btn custom-submit-class custom-submit-class-2" data-btn-text="Utility bill uploaded">Upload utility bill</button>
							                                <!-- The file input field used as target for the file upload widget -->    
							                                <input class="bill_upload" type="file" name="files" data-fieldname="shareholder_{{ $key+1 }}_bill" data-selector="shareholder_{{ $key+1 }}" />
							                            </span>                
							                            <!-- The container for the uploaded files -->
							                            <div id="shareholder_{{ $key+1 }}_bill_files" class="files"><p>{{ $shareholder->bill }}</p></div>
							        				</div>
						        				</fieldset>
			        						</div>
			        					</div>	        					
		        					@endforeach
	        					@endif	        					
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<p>Directors</p>
							</div>
							<div class="col-md-8">								
	        					@if(count($company->companywpuser_directors) > 0)
		        					@foreach($company->companywpuser_directors as $key => $director)
			        					<div class="row each-director">
			        						<div class="col-md-12">
			        							<fieldset>
				        							<legend>Director {{ $key+1 }}</legend>
				        							<input type="hidden" class="person" name="prefix" value="director_{{ $key+1 }}">
				        							<input type="hidden" class="person" name="director_{{ $key+1 }}_companywpuser_director_id" value="{{ $director->id }}">
				        							<input type="hidden" class="person" name="director_{{ $key+1 }}_person_role" value="director">

				        							<div class="each-input">
						        						<label for="director_{{ $key+1 }}_type">Type</label>
						        						@if($director->type==1)
															<span>{{ "Individual" }}</span>
						        						@else
															<span>{{ "Company" }}</span>
						        						@endif
						        						<input type="hidden" name="director_{{ $key+1 }}_type" id="director_{{ $key+1 }}_type" value="{{ $director->type }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_name">Name</label>
							        					<input type="text" class="person" name="director_{{ $key+1 }}_name" value="{{ $director->name }}">
							        				</div>
							        				<div class="each-input">
				        								<label for="director_{{ $key+1 }}_person_code">Person code</label>
				        								<input type="text" class="director person" name="director_{{ $key+1 }}_person_code" value="{{ $director->person_code }}" >
				        							</div>
				        							{{-- <div class="each-input">
							        					<button type="button" class="add-to-person custom-submit-class custom-submit-class-2">Add to person database</button>
							        				</div> --}}
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_address">Address (Street)</label>
							        					<input type="text" class="person" name="director_{{ $key+1 }}_address" value="{{ $director->address }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_address_2">Address 2 (City)</label>
							        					<input type="text" class="person" name="director_{{ $key+1 }}_address_2" value="{{ $director->address_2 }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_address_3">Address 3 (State)</label>
							        					<input type="text" class="person" name="director_{{ $key+1 }}_address_3" value="{{ $director->address_3 }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_address_4">Address 4 (Country)</label>
							        					<?php 
							        					$keyplus = $key+1;
							        					$name = "director_".$keyplus."_address_4";
							        					?>
							        					{!! Form::select($name, $countryList, $director->address_4) !!}
							        				</div>
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_telephone">Telephone</label>
							        					<input type="text" class="person" name="director_{{ $key+1 }}_telephone" value="{{ $director->telephone }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_passport">Passport</label>
														<input type="hidden" class="person" name="director_{{ $key+1 }}_passport" value="{{ $director->passport }}" />
						                                <span class="btn fileinput-button">                            
						                                    <button class="upload-passport-btn custom-submit-class custom-submit-class-2" data-btn-text="Passport uploaded">Upload passport</button>
						                                
						                                    <input class="passport_upload" type="file" name="files" data-fieldname="director_{{ $key+1 }}_passport" data-selector="director_{{ $key+1 }}" />
						                                </span>
						                
						                                <div id="director_{{ $key+1 }}_passport_files" class="files"><p>{{ $director->passport }}</p></div>
							        				</div>
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_bill">Bill</label>
														<input type="hidden" class="person" name="director_{{ $key+1 }}_bill" value="{{ $director->bill }}" />
						                                <span class="btn fileinput-button">                            
						                                    <button class="upload-bill-btn custom-submit-class custom-submit-class-2" data-btn-text="Utility bill uploaded">Upload utility bill</button>
						                           
						                                    <input class="bill_upload" type="file" name="files" data-fieldname="director_{{ $key+1 }}_bill" data-selector="director_{{ $key+1 }}" />
						                                </span>                
						                                <div id="director_{{ $key+1 }}_bill_files" class="files"><p>{{ $director->bill }}</p></div>	
							        				</div>							        				
						        				</fieldset>
			        						</div>
			        					</div>	        					
		        					@endforeach	
	        					@endif		
	        					@if($company->wpusers[0]->pivot->nominee_director==1)
	        						<div class="row each-director">
		        						<div class="col-md-12">
			        						<fieldset>
			        							<legend>Nominee director</legend>				
				        						<div class="each-input">
				        							<label for="nominee_director_person_code">Person Code</label>						        
						        					<input type="text" name="nominee_director_person_code" class="nominee_director" value="{{ $companywpuser->nominee_director_person_code }}">
				        						</div>
				        					</fieldset>
        								</div>
		        					</div>
	        					@endif					
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<p>Secretaries</p>
							</div>
							<div class="col-md-8">								
	        					@if(count($company->companywpuser_secretaries) > 0)
		        					@foreach($company->companywpuser_secretaries as $key => $secretary)
										<div class="row each-director">
			        						<div class="col-md-12">
			        							<fieldset>
				        							<legend>Secretary {{ $key+1 }}</legend>
													<input type="hidden" class="person" name="prefix" value="secretary_{{ $key+1 }}">
				        							<input type="hidden" class="person" name="secretary_{{ $key+1 }}_companywpuser_secretary_id" value="{{ $secretary->id }}">
				        							<input type="hidden" class="person" name="secretary_{{ $key+1 }}_person_role" value="secretary">

				        							<div class="each-input">
						        						<label for="secretary_{{ $key+1 }}_type">Type</label>
						        						@if($secretary->type==1)
															<span>{{ "Individual" }}</span>
						        						@else
															<span>{{ "Company" }}</span>
						        						@endif
						        						<input type="hidden" name="secretary_{{ $key+1 }}_type" id="secretary_{{ $key+1 }}_type" value="{{ $secretary->type }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_name">Name</label>
							        					<input type="text" class="person" name="secretary_{{ $key+1 }}_name" value="{{ $secretary->name }}">
							        				</div>
							        				<div class="each-input">
				        								<label for="secretary_{{ $key+1 }}_person_code">Person code</label>
				        								<input type="text" class="person secretary" name="secretary_{{ $key+1 }}_person_code" value="{{ $secretary->person_code }}" >
				        							</div>
				        							{{-- <div class="each-input">
							        					<button type="button" class="add-to-person custom-submit-class custom-submit-class-2">Add to person database</button>
							        				</div> --}}
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_address">Address (Street)</label>
							        					<input type="text" class="person" name="secretary_{{ $key+1 }}_address" value="{{ $secretary->address }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_address_2">Address 2 (City)</label>
							        					<input type="text" class="person" name="secretary_{{ $key+1 }}_address_2" value="{{ $secretary->address_2 }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_address_3">Address 3 (State)</label>
							        					<input type="text" class="person" name="secretary_{{ $key+1 }}_address_3" value="{{ $secretary->address_3 }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_address_4">Address 4 (Country)</label>
							        					<?php 
							        					$keyplus = $key+1;
							        					$name = "secretary_".$keyplus."_address_4";
							        					?>
							        					{!! Form::select($name, $countryList, $secretary->address_4) !!}			
							        				</div>
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_telephone">Telephone</label>
							        					<input type="text" class="person" name="secretary_{{ $key+1 }}_telephone" value="{{ $secretary->telephone }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_passport">Passport</label>
														<input type="hidden" class="person" name="secretary_{{ $key+1 }}_passport" value="{{ $secretary->passport }}" />
							                            <span class="btn fileinput-button">
							                                <button class="upload-passport-btn custom-submit-class custom-submit-class-2" data-btn-text="Passport uploaded">Upload passport</button>
							                                
							                                <input class="passport_upload" type="file" name="files" data-fieldname="secretary_{{ $key+1 }}_passport" data-selector="secretary_{{ $key+1 }}" />
							                            </span>
							                            
							                            <div id="secretary_{{ $key+1 }}_passport_files" class="files"><p>{{ $secretary->passport }}</p></div>
							        				</div>
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_bill">Bill</label>
							        					<input type="hidden" class="person" name="secretary_{{ $key+1 }}_bill" value="{{ $secretary->bill }}" />
						                                <span class="btn fileinput-button">                            
						                                    <button class="upload-btn upload-bill-btn custom-submit-class custom-submit-class-2" data-btn-text="Utility bill uploaded">Upload utility bill</button>
						                                                      
						                                    <input class="bill_upload" type="file" name="files" data-fieldname="secretary_{{ $key+1 }}_bill" data-selector="secretary_{{ $key+1 }}" />
						                                </span>                
						                                
						                                <div id="secretary_{{ $key+1 }}_bill_files" class="files"><p>{{ $secretary->bill }}</p></div>
							        				</div>							        				
						        				</fieldset>
			        						</div>
			        					</div>
		        					@endforeach
		        				@endif
		        				@if($company->wpusers[0]->pivot->nominee_secretary==1)
	        						<div class="row each-director">
		        						<div class="col-md-12">
			        						<fieldset>
			        							<legend>Nominee secretary</legend>				
				        						<div class="each-input">
				        							<label for="nominee_secretary_person_code">Person Code</label>						        
						        					<input type="text" name="nominee_secretary_person_code" class="nominee_secretary" value="{{ $companywpuser->nominee_secretary_person_code }}">
				        						</div>
				        					</fieldset>
        								</div>
		        					</div>
	        					@endif
							</div>
						</div>
						@if(count($servicescountries) > 1)								
						<div class="row">
							<div class="col-md-4">
								<p>Services</p>
							</div>
							<div class="col-md-8">
								<table class="table table-striped">
		                    		@foreach($servicescountries as $servicecountry)        	
	                    				<tr>	                    					
	                    					@if($servicecountry->service_name!=="Registered office annual fee (compulsory)")
		                    					<td>{{ $servicecountry->service_name }}</td>
		                    					<td>{{ $servicecountry->country_name }}</td>
		                    					<td>{{ ($servicecountry->pivot->credit_card_count==0) ? "" : $servicecountry->pivot->credit_card_count }}</td>
	                    					@endif
	                    				</tr>
		                    		@endforeach
	                    		</table>
							</div>
						</div>	
						@endif
						@if(count($informationservices) > 0)		
						<div class="row">
							<div class="col-md-4">
								<p>Infomation services</p>
							</div>
							<div class="col-md-8">
								<table class="table table-striped">
		                    		@foreach($informationservices as $informationservice)	
		                    			<tr>
		                    				<td>{{ $informationservice->name }}</td>
		                    			</tr>
		                    		@endforeach
	                    		</table>
							</div>
						</div>
						@endif
						<div class="row">
							<div class="col-md-4"><p>Date of next accounts</p></div>	
							<div class="col-md-8"><input type="text" name="date_of_next_accounts" id="date_of_next_accounts" value="{{ (strtotime($companywpuser->date_of_next_accounts) <= 0) ? $companywpuser->date_of_next_accounts : date('d M Y', strtotime($companywpuser->date_of_next_accounts)) }}"></div>			
						</div>
						<div class="row">
							<div class="col-md-4"><p>Date of last accounts</p></div>	
							<div class="col-md-8"><input type="text" name="date_of_last_accounts" id="date_of_last_accounts" value="{{ (strtotime($companywpuser->date_of_last_accounts) <= 0) ? $companywpuser->date_of_last_accounts : date('d M Y', strtotime($companywpuser->date_of_last_accounts)) }}"></div>			
						</div>						
						<div class="row">
							<div class="col-md-4"><p>Accounts completion deadline</p></div>	
							<div class="col-md-8"><input type="text" name="accounts_completion_deadline" id="accounts_completion_deadline" value="{{ (strtotime($companywpuser->accounts_completion_deadline) <= 0) ? $companywpuser->accounts_completion_deadline : date('d M Y', strtotime($companywpuser->accounts_completion_deadline)) }}"></div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p>Date of last VAT return</p></div>	
							<div class="col-md-8"><input type="text" name="date_of_last_vat_return" id="date_of_last_vat_return" value="{{ (strtotime($companywpuser->date_of_last_vat_return) <= 0) ? $companywpuser->date_of_last_vat_return : date('d M Y', strtotime($companywpuser->date_of_last_vat_return)) }}"></div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p>Date of next VAT return</p></div>	
							<div class="col-md-8"><input type="text" name="date_of_next_vat_return" id="date_of_next_vat_return" value="{{ (strtotime($companywpuser->date_of_next_vat_return) <= 0) ? $companywpuser->date_of_next_vat_return : date('d M Y', strtotime($companywpuser->date_of_next_vat_return)) }}"></div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p>VAT return deadline</p></div>	
							<div class="col-md-8"><input type="text" name="vat_return_deadline" id="vat_return_deadline" value="{{ (strtotime($companywpuser->vat_return_deadline) <= 0) ? $companywpuser->vat_return_deadline : date('d M Y', strtotime($companywpuser->vat_return_deadline)) }}"></div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p>Next AGM due by</p></div>	
							<div class="col-md-8"><input type="text" name="next_agm_due_by" id="next_agm_due_by" value="{{ (strtotime($companywpuser->next_agm_due_by) <= 0) ? $companywpuser->next_agm_due_by : date('d M Y', strtotime($companywpuser->next_agm_due_by)) }}"></div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p>Next domiciliation renewal</p></div>	
							<div class="col-md-8"><input type="text" name="next_domiciliation_renewal" id="next_domiciliation_renewal" value="{{ (strtotime($companywpuser->next_domiciliation_renewal) <= 0) ? $companywpuser->next_domiciliation_renewal : date('d M Y', strtotime($companywpuser->next_domiciliation_renewal)) }}"></div>			
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text-2">Incorporation certificate</p></div><!--
							--><div class="col-md-4">
								<input type="hidden" name="incorporation_certificate" value="{{ $companywpuser->incorporation_certificate }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Certificate uploaded">Upload certificate</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="incorporation_certificate" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="incorporation_certificate_files" class="pdf_files files"><p>{{ $companywpuser->incorporation_certificate }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text-2">Incumbency certificate</p></div><!--
							--><div class="col-md-4">
								<input type="hidden" name="incumbency_certificate" value="{{ $companywpuser->incumbency_certificate }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Certificate uploaded">Upload certificate</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="incumbency_certificate" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="incumbency_certificate_files" class="pdf_files files"><p>{{ $companywpuser->incumbency_certificate }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text-2" class="align-text">Company extract</p></div><!--
							--><div class="col-md-4">
								<input type="hidden" name="company_extract" value="{{ $companywpuser->company_extract }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Extract uploaded">Upload extract</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="company_extract" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="company_extract_files" class="pdf_files files"><p>{{ $companywpuser->company_extract }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text-2">Last financial statements</p></div><!--
							--><div class="col-md-4">
								<input type="hidden" name="last_financial_statements" value="{{ $companywpuser->last_financial_statements }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Statement uploaded">Upload statements</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="last_financial_statements" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="last_financial_statements_files" class="pdf_files files"><p>{{ $companywpuser->last_financial_statements }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Documents 5</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_1_title" placeholder="Document title" value="{{ $companywpuser->other_documents_1_title }}">
								<input type="hidden" name="other_documents_1" value="{{ $companywpuser->other_documents_1 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Document uploaded">Upload document</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_1" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_1_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_1 }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Documents 6</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_2_title" placeholder="Document title" value="{{ $companywpuser->other_documents_2_title }}">
								<input type="hidden" name="other_documents_2" value="{{ $companywpuser->other_documents_2 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Document uploaded">Upload document</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_2" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_2_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_2 }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Documents 7</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_3_title" placeholder="Document title" value="{{ $companywpuser->other_documents_3_title }}">
								<input type="hidden" name="other_documents_3" value="{{ $companywpuser->other_documents_3 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Document uploaded">Upload document</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_3" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_3_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_3 }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Documents 8</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_4_title" placeholder="Document title" value="{{ $companywpuser->other_documents_4_title }}">
								<input type="hidden" name="other_documents_4" value="{{ $companywpuser->other_documents_4 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Document uploaded">Upload document</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_4" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_4_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_4 }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Documents 9</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_5_title" placeholder="Document title" value="{{ $companywpuser->other_documents_5_title }}">
								<input type="hidden" name="other_documents_5" value="{{ $companywpuser->other_documents_5 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Document uploaded">Upload document</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_5" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_5_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_5 }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Documents 10</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_6_title" placeholder="Document title" value="{{ $companywpuser->other_documents_6_title }}">
								<input type="hidden" name="other_documents_6" value="{{ $companywpuser->other_documents_6 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Document uploaded">Upload document</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_6" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_6_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_6 }}</p></div>								
							</div>						
						</div>
						<input type="submit" name="submit" value="Save" class="save custom-submit-class">
						<input type="submit" name="submit" value="Approve" class="approve custom-submit-class">
						<input type="submit" name="submit" value="Reject" class="reject custom-submit-class">
					</div>					
				{{ Form::close() }}
			</div>
		</div>
	</div>
	<div class="space100"></div>
	<script>

		///////////
        /// FILE UPLOAD
        ///////////

        function initFileUpload($selector) {
            $selector.each(function(i, obj) {
                var $button = $(obj).prev("button");                    
                var selector = $(obj).attr("data-fieldname");

                var url = "{{ url('api/uploadfiles') }}";
                $(obj).fileupload({
                    url: url,
                    dataType: "json",
                    formData: { "user_name" : "{{ $company->wpusers[0]->user_login }}" },
                    done: function (e, data) {

                        var shortText = jQuery.trim(data.result.file.org_name).substring(0, 30).trim(this);

                        $("input[name="+selector+"]").val(data.result.file.name);
                        $("#"+selector+"_files").html("");
                        $("<p/>").text(shortText).appendTo("#"+selector+"_files");
                        $("#"+selector+"_files").parent().find("label.error").hide();

                        $button.text($button.data("btn-text"));

                    }
                }).prop("disabled", !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : "disabled"); 

            });                

        }

		initFileUpload($(".passport_upload"));
        initFileUpload($(".bill_upload"));
        initFileUpload($(".pdf_upload"));

        $(".passport_upload").each(function(i, obj){
            var selector = $(obj).data("selector");
            var $this = $(this);                    

            if($("#"+selector+"_type").val()==2) {
                $this.prev("button").text("Upload incorporation certificate").data("btn-text", "Incorporation certificate uploaded");
                $this.parent().parent().find("label").text("Upload incorporation certificate");
            }
        });

        $(".bill_upload").each(function(i, obj){
            var selector = $(obj).data("selector");
            var $this = $(this);                    

            if($("#"+selector+"_type").val()==2) {
                $this.prev("button").text("Upload memo & articles").data("btn-text", "Memo & articles uploaded");
                $this.parent().parent().find("label").text("Upload memo & articles");
            }
        });

        $(".upload-passport-btn").on("click", function(e){
            e.preventDefault();
        });

        $(".upload-bill-btn").on("click", function(e){
            e.preventDefault();
        });

        $(".upload-pdf-btn").on("click", function(e){
            e.preventDefault();
        });

        $('#incorporation_date').datepicker({ dateFormat: 'dd/mm/y' });
        $('#date_of_next_accounts').datepicker({ dateFormat: 'dd/mm/y' });
        $('#date_of_last_accounts').datepicker({ dateFormat: 'dd/mm/y' });
        $('#accounts_completion_deadline').datepicker({ dateFormat: 'dd/mm/y' });
        $('#date_of_last_vat_return').datepicker({ dateFormat: 'dd/mm/y' });
        $('#date_of_next_vat_return').datepicker({ dateFormat: 'dd/mm/y' });
        $('#vat_return_deadline').datepicker({ dateFormat: 'dd/mm/y' });
        $('#next_agm_due_by').datepicker({ dateFormat: 'dd/mm/y' });
        $('#next_domiciliation_renewal').datepicker({ dateFormat: 'dd/mm/y' });

        $.fn.serializeObject = function()
		{
		    var o = {};
		    var a = this.serializeArray();
		    $.each(a, function() {
		        if (o[this.name] !== undefined) {
		            if (!o[this.name].push) {
		                o[this.name] = [o[this.name]];
		            }
		            o[this.name].push(this.value || '');
		        } else {
		            o[this.name] = this.value || '';
		        }
		    });
		    return o;
		};

		//////////
        /// AJAX REQUEST
        //////////

        function makeRequest(Data, URL, Method) {

            var request = $.ajax({
                url: URL,
                type: Method,
                data: Data,
                success: function(response) {
                    // if success remove current item
                    // console.log(response);
                },
                error: function( error ){
                    // Log any error.
                    console.log("ERROR:", error);
                }
            });

            return request;
        };

        $(".add-to-person").on("click", function(e){
        	e.preventDefault();
        	var $this = $(this);
        	var $inputs = $(this).parent().parent('fieldset').find('.person');

        	data = $inputs.serializeObject();

        	var missing_fields = [];

        	$.each(data, function(i, val) {
        		if(val=="" && i.indexOf('passport') === -1 && i.indexOf('bill') === -1) missing_fields = i;
        		var field = $("input[name="+i+"]").prev("label").text();
        		$("input[name="+i+"]").attr("placeholder", field+" is required.").addClass("error");
        	});

        	if(missing_fields.length <= 0) {
        		var response = makeRequest(data, "{{ url('api/addtopersondb') }}", "POST");

	        	response.done(function(dataResponse, textStatus, jqXHR){                    
	                if(jqXHR.status==200) {
	                	if(dataResponse.message=="Success") {
	                		$this.after("<span style='padding-left:5px;'>Successfully added to person</span>");
	                	}
	                }
	            });
        	}
        });

        $(".add-user-to-person").on("click", function(e){
        	e.preventDefault();
        	var $this = $(this);    
        	var $inputs = $(this).parent().parent('fieldset').find('.person');        	

        	var missing_fields = [];    	

        	if($("#user_person_code").val()=="") {
        		$("#user_person_code").attr("placeholder", "Person code is required.").addClass("error");
        		missing_fields = 'user_person_code';
        	}

        	if(missing_fields.length <= 0) {

        		data = $inputs.serializeObject();

        		var response = makeRequest(data, "{{ url('api/addusertopersondb') }}", "POST");

	        	response.done(function(dataResponse, textStatus, jqXHR){                    
	                if(jqXHR.status==200) {
	                	if(dataResponse.message=="Success") {
	                		$this.after("<span style='padding-left:5px;'>Successfully added to person</span>");
	                	}
	                }
	            });
        	}
        });

        var persons = [];

        <?php
        foreach ($person as $key => $value):
        ?>
        	persons.push('<?php echo $value->person_code; ?>');

        <?php
        endforeach;
		?>

		$(".add-user-to-person").hide();
		$( "#user_person_code" ).autocomplete({
			source: persons		
		});

		$("#user_person_code").on("change keyup paste", function(e){
			var inputValue = $(this).val();

			if(jQuery.inArray(inputValue, persons) == -1 && inputValue!= "") {
				$(".add-user-to-person").show();
			}else {
				$(".add-user-to-person").hide();
			}
		});

		$( ".shareholder" ).autocomplete({
			source: persons
		});

		$(".add-to-person").hide();
		$(".shareholder").on("change keyup paste", function(e){
			var inputValue = $(this).val();

			if(jQuery.inArray(inputValue, persons) == -1 && inputValue!= "") {
				$(this).parent().next('.each-input').find(".add-to-person").show();
			}else {
				$(this).parent().next('.each-input').find(".add-to-person").hide();
			}
		});

		$( ".director" ).autocomplete({
			source: persons
		});
		$(".director").on("change keyup paste", function(e){
			var inputValue = $(this).val();

			if(jQuery.inArray(inputValue, persons) == -1 && inputValue!= "") {
				$(this).parent().next('.each-input').find(".add-to-person").show();
			}else {
				$(this).parent().next('.each-input').find(".add-to-person").hide();
			}
		});
		
		$( ".secretary" ).autocomplete({
			source: persons
		});
		$(".secretary").on("change keyup paste", function(e){
			var inputValue = $(this).val();

			if(jQuery.inArray(inputValue, persons) == -1 && inputValue!= "") {
				$(this).parent().next('.each-input').find(".add-to-person").show();
			}else {
				$(this).parent().next('.each-input').find(".add-to-person").hide();
			}
		});

        $( ".nominee_shareholder" ).autocomplete({
	      	source: function( request, response ) {
		        $.ajax({
		          url: "{{ url('api/getperson') }}",
		          success: function( data ) {		 			
		          	var update_to_date_persons = [];
		          	if(data.length){
		          		$.each(data, function(i, v) {
		          			update_to_date_persons.push(v.person_code);
		          		});
		          	}

		            // Handle 'no match' indicated by [ "" ] response
		            response( data.length === 1 && data[ 0 ].length === 0 ? [] : update_to_date_persons );
		          }
		        });
	      	},
	      	change: function (event, ui) {
                if(!ui.item){
                    //http://api.jqueryui.com/autocomplete/#event-change -
                    // The item selected from the menu, if any. Otherwise the property is null
                    //so clear the item for force selection
                    $(".shareholder").val("");
                }

            }
	    });

	    $( ".nominee_director" ).autocomplete({
	      	source: persons,
	      	change: function (event, ui) {
                if(!ui.item){
                    //http://api.jqueryui.com/autocomplete/#event-change -
                    // The item selected from the menu, if any. Otherwise the property is null
                    //so clear the item for force selection
                    $(".director").val("");
                }

            }
	    });

	     $( ".nominee_secretary" ).autocomplete({
	      	source: persons,
	      	change: function (event, ui) {
                if(!ui.item){
                    //http://api.jqueryui.com/autocomplete/#event-change -
                    // The item selected from the menu, if any. Otherwise the property is null
                    //so clear the item for force selection
                    $(".secretary").val("");
                }

            }
	    });

	</script>
@endsection