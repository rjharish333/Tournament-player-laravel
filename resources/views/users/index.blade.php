@extends('layout.mainlayout')
@section('content')	

<div class="page-wrapper">
			<div class="content container-fluid">
			
				<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col">
								<h3 class="page-title"><i class="fas fa-user-tie"></i> Members</h3>
								
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
									@if(Auth::user()->role_id !== 1)
									<h5 style="margin-bottom: 30px ;">Active Team : <b> {{$team ? $team : "All"}} </b></h5>
									@endif
									<form method="get" action="{{route('members.index')}}">
										@csrf

									<div class="row">
															
				                        <div class="form-group col-3 col-md-3">
			                                <label class="text-white" for="">Region</label>
			                                <select name="region" id="filter_region" class="form-control">
											  <option value="">All Regions</option>
											  @foreach($regions as $value)
											  	<option value="{{$value->id}}" {{$value->id == $region?'selected':''}}>{{strtoupper($value->region_name)}}</option>
											  @endforeach
											</select>
				                        </div>
				                    <!-- </div>
				                    <div class="row"> -->
									  <div class="form-group col-3 col-md-3">
									  	<label class="text-white" for="">Search</label>
									    <input type="text" name="search" value="{{$search??''}}" class="form-control mr-3" id="" placeholder="search">
										</div>
										<div class="form-group col-1 col-md-1" style="margin-top: 2rem!important;">
									   	<button type="submit" class="btn btn-primary">Search</button>
										</div>

										<div class="form-group col-2 col-md-2" style="margin-top: 2rem!important;">
											<a href="{{route('members.index')}}">
									   			<button type="button" class="btn btn-danger">Reset Filter</button>
									   		</a>
										</div>
									
									  </div>
									</div>
									</form>
								<div class="row mt-3">
									<div class="col-md-3 offset-md-9">
								  		<a href="{{route('member.create')}}"><button class="btn btn-success mb-3 float-right">Add Member <i class="fas fa-plus-circle"></i> </button></a>

								  		<!-- <a data-target="#importUsers" data-toggle="modal"><button class="mb-3 btn btn btn-secondary" style="margin-left:10px"><i class="fas fa-file-excel"></i> Import Users</button></a> -->
								  	</div>
								</div>
								  @if(session()->has('success'))
									    <p class="alert alert-success">{{ Session::get('success') }}</p>
									@endif

									@if(session()->has('error'))
									    <span class="invalid-feedback" role="alert">
				                          <strong>{{ $message }}</strong>
				                      </span>
									@endif
				                  <table id="" class="display table dataTable table-striped table-bordered" >
				                     <thead>
				                        <tr>
				                           <th>#</th>
				                           <th>User Name</th>
				                           <!-- <th>Team</th> -->
				                           <th>Region</th>
				                           <th>Phone</th>
				                           <th>DOB</th>
				                           <th>Street</th>
				                           <th>City</th>
				                           <th>Payment Status</th>
				                           <th>Status</th>
				                           <th>Created At</th>
				                           <th>Action</th>
				                        </tr>
				                     </thead>
				                     <tbody>
				                     	@if(count($users) > 0)
				                     	@foreach($users as $key => $user)

				                     	<tr>
				                     		<td>{{ $users->firstItem() + $key }}</td>
				                     		<td>{{ ucfirst($user->first_name) ." ". ucfirst($user->last_name) }}<br /><font style="font-size:10px"><i class="fas fa-envelope"></i>  {{ $user->email }}</font></td>
				                     		<!-- <td>{{ $user->team->team_name??'NA' }}</td> -->
				                     		<td>{{ strtoupper($user->region->region_name)??'NA' }}<br /></td>
				                     		<td>+{{ $user->phone }}</td>
				                     		<td>{{ date('d M Y', strtotime($user->dob) )}}</td>
				                     		<td>{{ $user->street }}</td>
				                     		<td>{{ $user->city . ", " . $user->getCountry->name??'' }} <br /><font style="font-size:10px">  #{{ $user->postal_code }}</font></td>
				                     		<td>
					                        	{{$user->status==1?'Paid':'Pending'}}
					                        </td>
				                     		<td>
					                        	{{$user->status==1?'Active':'Inactive'}}
					                        </td>
				                     		<td>{{ date('d M Y', strtotime($user->created_at) )}}</td>
				                     		<td>
					                            <a href="{{route('member.edit', $user->id)}}" class="btn btn-info" >
					                              <i class="fas fa-edit"></i>
					                            </a>

					                            <a onclick="return confirm('Are you sure you want to delete?');" href="{{route('member.destroy', $user->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
				                     		</td>
				                     	</tr>
				                     	@endforeach
				                     	@else
			                                <tr>
			                                    <td colspan="10">No Members Found</td>
			                                </tr>
			                            @endif
			                            </tbody>
			                            <tfoot>
				                           <tr>
				                               <th>#</th>
					                           <th>User Name</th>
					                           <!-- <th>Team</th> -->
					                           <th>Region</th>
					                           <th>Phone</th>
					                           <th>DOB</th>
					                           <th>Street</th>
					                           <th>City</th>
				                          	   <th>Payment Status</th>
					                           <th>Status</th>
					                           <th>Created At</th>
					                           <th>Action</th>
				                           </tr>
				                        </tfoot>
			                        </table>
			                        
			                        {{ $users->appends(request()->except('page'))->links() }}
								</div>
							</div>
						</div>
					</div>
				
				</div>			
			</div>
			<!-- /Main Wrapper -->
	</div>
@endsection 
