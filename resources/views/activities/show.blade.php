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
									
									
								  @if(session()->has('success'))
									    <p class="alert alert-success">{{ Session::get('success') }}</p>
									@endif

									@if(session()->has('error'))
									    <span class="invalid-feedback" role="alert">
				                          <strong>{{ $message }}</strong>
				                      </span>
									@endif

									<div class="row mt-3">
										<div class="col-md-3">
									  		<a href="{{route('activities.index')}}"><button class="btn btn-info mb-3 float-left">Back </button></a>
									  	</div>
									</div>
				                  
				                  <div class="row">
				                  	<div class="col-6" style="padding: 10px;">
				                  		<div class="card bg-light mb-3">
										  <div class="card-header">Details</div>
										  <div class="card-body">
										  	<div class="row">
											    <div class="col-6">
											    	<span class="text-grey">Created By</span>
											    	<span class="text-grey">{{$data->user->first_name . " " .$data->user->last_name}}</span>
											    </div>
											    <div class="col-6">
											    	@if($ownerStatus === false)
											    	<a href="{{route('activity.attending', $data->id)}}"><button class="btn btn-success">Attend</button></a>
											    	<a href="{{route('activity.not-attending', $data->id)}}"><button class="btn btn-warning">Not Attending</button></a>
											    	@elseif($ownerStatus === 'attending')
											    	<span class="text-black">You are available</span>
											    	<a href="{{route('activity.not-attending', $data->id)}}"><button class="btn btn-warning">Not Attending</button></a>
											    	@elseif($ownerStatus === 'not-attending')
											    	<span class="text-black">You are Not available</span>
											    	<a href="{{route('activity.attending', $data->id)}}"><button class="btn btn-success">Attend</button></a>
											    	@endif

											    </div>
											</div>

											<div class="row">
											    <div class="col-6">
											    	<span class="text-grey">Activity Title</span> <br/>
											    	<span class="text-black">{{$data->activityType->name}}</span>
											    </div>
											    <div class="col-6">
											    	<span class="text-grey">Activity Type</span> <br/>
											    	<span class="text-black">{{$data->title}}</span>
											    </div>
											</div>

											<div class="row">
											    <div class="col-6">
											    	<span class="text-grey">Start Date</span> <br/>
											    	<span class="text-black">{{$data->start_date}}</span>
											    </div>
											    <div class="col-6">
											    	<span class="text-grey">Start Time</span> <br/>
											    	<span class="text-black">{{$data->starting_time}}</span>
											    </div>
											</div>

											<div class="row">
											    <div class="col-6">
											    	<span class="text-grey">End Date</span> <br/>
											    	@if($data->activity_end_another_date == '1')
											    	<span class="text-black">{{$data->end_date}}</span>
											    	@else
											    	<span class="text-black">{{$data->start_date}}</span>
											    	@endif
											    </div>
											    <div class="col-6">
											    	<span class="text-grey">End Time</span> <br/>
											    	<span class="text-black">{{$data->end_time}}</span>
											    </div>
											</div>

											<div class="row">
											    <div class="col-6">
											    	<span class="text-grey">Deadline</span> <br/>
											    	<span class="text-black">{{$data->register_end_date}} , {{$data->register_end_time}}</span>
											    </div>
											    <div class="col-6">
											    	<span class="text-grey">Max Participants</span> <br/>
											    	<span class="text-black">{{$data->max_participants}}</span>
											    </div>
											</div>

											<div class="row">
											    <div class="col-12">
											    	<span class="text-grey">Comments</span> <br/>
											    	<span class="text-black">{{$data->comments??'NA'}}</span>
											    </div>
											</div>
										  </div>
										</div>
				                  	</div>

				                  	<div class="col-6" style="padding: 10px;">
				                  		<div class="card bg-light mb-3">
										  <div class="card-header">Place</div>
										  <div class="card-body">
										    <div class="row">
											    <div class="col-6">
											    	<span class="text-grey">Place</span> <br/>
											    	<span class="text-black">{{$data->place}}</span>
											    </div>
											    <div class="col-6">
											    	<span class="text-grey">Meeting Place</span> <br/>
											    	<span class="text-black">{{$data->meeting_place}}</span>
											    </div>
											</div>
											<div class="row">
											    <div class="col-6">
											    	<span class="text-grey">Meeting Time</span> <br/>
											    	<span class="text-black">{{$data->meeting_time}}</span>
											    </div>
											    <div class="col-6">
											    	<span class="text-grey">Selection Type</span> <br/>
											    	<span class="text-black">{{$data->selectionType->name??'NA'}}</span>
											    </div>
											</div>
										  </div>
										</div>
				                  	</div>

				                  	<div class="col-6" style="padding: 10px;">
				                  		<div class="card bg-light mb-3">
										  <div class="card-header">Registration</div>
										  <div class="card-body">
										    <div class="col-6">
										    	<span class="text-grey">Registered ( 0 )</span> <br/>
										    	<span class="text-black">No Attendees</span>
										    </div>
										     <div class="col-6">
										    	<span class="text-grey">Not attending ( {{$nonattendeeCount}} )</span> <br/>
										    	<span class="text-black">No non-attendees</span>
										    </div>
										     <div class="col-6">
										    	<span class="text-grey">Available ( {{$attendeeCount}} )</span> <br/>
										    	<span class="text-black">No Available</span>
										    </div>
										    <div class="col-6">
										    	<span class="text-grey">Undecided ( 10 )</span> <br/>
										    	<span class="text-black">Test1</span><br/>
										    	<span class="text-black">Test2</span>
										    </div>
										  </div>
										</div>
				                  	</div>

				                  	<div class="col-6" style="padding: 10px;">
				                  		<div class="card bg-light mb-3">
										  <div class="card-header">Driving</div>
										  <div class="card-body">
										    <div class="row">
											    <div class="col-6">
											    	<span class="text-grey">Driving</span> <br/>
											    	<span class="text-black">{{$data->with_driving == '0' ?'Driving is not activated': $data->with_driving}}</span>
											    </div>
											</div>
										  </div>
										</div>
				                  	</div>

				                  	<div class="col-6" style="padding: 10px;">
				                  		<div class="card bg-light mb-3">
										  <div class="card-header">Chat</div>
										  <div class="card-body">
										    <p class="card-text">Coming Soon...</p>
										  </div>
										</div>
				                  	</div>
				                  </div>
			                        
								</div>
							</div>
						</div>
					</div>
				
				</div>			
			</div>
			<!-- /Main Wrapper -->
	</div>
@endsection 
