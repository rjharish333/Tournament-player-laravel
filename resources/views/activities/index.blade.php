@extends('layout.mainlayout')
@section('content')	

<div class="page-wrapper">
			<div class="content container-fluid">
			
				<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col">
								<h3 class="page-title"><i class="{{$icon}}" aria-hidden="true"></i> Activities</h3>
								
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
									
									<form method="get" action="{{route('activities.index')}}">
										@csrf

									<div class="row">
															
				                        <div class="form-group col-3">
			                                <label for="">Activity Type</label>
			                                <select name="activity_type" id="activity_type" class="form-control" >
			                                  <option value="">Select Type</option>
			                                @foreach($activity_types as $value)
			                                  <option value="{{$value->id }}" {{isset($activity_type) && $activity_type == $value->id ? "selected": ""}}>{{ucfirst($value->name)}}</option>
			                                 @endforeach
			                                </select>
			                              </div>

			                              @if($team)
			                              <div class="form-group col-3">
			                                <label for="">Team</label>
			                                <select name="team_id" id="team_id" class="form-control" >
			                                  <option value="{{$team->id}}">{{$team->team_name}}</option>
			                                  <option value="all">All Teams</option>
			                                </select>
			                              </div>
			                              @endif
			                              <div class="form-group col-3 col-md-3">
										  	<label class="text-white" for="">Start Date</label>
										    <input type="date" name="start_date" value="{{$start_date??''}}" class="form-control mr-3" id="" placeholder="Start Date">
										  </div>

										<div class="form-group col-3 col-md-3">
										  	<label class="text-white" for="">End Date</label>
										    <input type="date" name="end_date" value="{{$end_date??''}}" class="form-control mr-3" id="" placeholder="End Date">
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
											<a href="{{route('activities.index')}}">
									   			<button type="button" class="btn btn-danger">Reset Filter</button>
									   		</a>
										</div>
									
									  </div>
									</div>
									</form>
								<div class="row mt-3">
									<div class="col-md-3 offset-md-9">
								  		<a href="{{route('activity.create')}}"><button class="btn btn-success mb-3 float-right">Add Activity <i class="fas fa-plus-circle"></i> </button></a>
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
				                           <th>Activity Name</th>
				                           <th>Team Name</th>
				                           <th>Start Activity</th>
				                           <th>Meeting place</th>
				                           <th>Max Participants</th>
				                           <th>Register Start Date</th>
				                           <th>Register End Date</th>
				                           <th>Created At</th>
				                           <th>Action</th>
				                        </tr>
				                     </thead>
				                     <tbody>
				                     	@if(count($data) > 0)
				                     	@foreach($data as $key => $value)

				                     	<tr>
				                     		<td>{{ $data->firstItem() + $key }}</td>
				                     		<td>{{$value->title}} <font style="font-size:10px"> <br/>Activity Type: {{ $value->activityType->name??'NA' }}</font></td>
				                     		<td>{{$value->team->team_name}}</td>
				                     		<td>Start Date: <b>{{$value->start_date}} </b><br /><font style="font-size:10px">End Date: {{ $value->end_date??'NA' }}</font></td>
				                     		<td>{{ $value->meeting_place }}<br /><font style="font-size:10px">Time: {{ $value->meeting_time??'NA' }}</font></td>
				                     		<td>{{ $value->max_participants }}</td>
				                     		<td>{{ $value->register_start_date??'NA' }}</td>
				                     		<td>{{ $value->register_end_date }}</td>
				                     		<td>{{ date('d M Y', strtotime($value->fld_created_at) )}}</td>
				                     		<td>
					                            <a href="{{route('activity.show', $value->id)}}" class="btn btn-info" >
					                              <i class="fas fa-eye"></i>
					                            </a>

					                            <a onclick="return confirm('Are you sure you want to delete?');" href="{{route('activity.destroy', $value->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
				                     		</td>
				                     	</tr>
				                     	@endforeach
				                     	@else
			                                <tr>
			                                    <td colspan="10">No Activity Found</td>
			                                </tr>
			                            @endif
			                            </tbody>
			                            <tfoot>
				                           <tr>
				                                <th>#</th>
					                           <th>Activity Name</th>
					                           <th>Team Name</th>
					                           <th>Start Activity</th>
					                           <th>Meeting place</th>
					                           <th>Max Participants</th>
					                           <th>Register Start Date</th>
					                           <th>Register End Date</th>
					                           <th>Created At</th>
					                           <th>Action</th>
				                           </tr>
				                        </tfoot>
			                        </table>
			                        
			                        {{ $data->appends(request()->except('page'))->links() }}
								</div>
							</div>
						</div>
					</div>
				
				</div>			
			</div>
			<!-- /Main Wrapper -->
	</div>
@endsection 
