@extends('layout.mainlayout')
@section('content')	
<div class="page-wrapper">
			<div class="content container-fluid">
			
				<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col">
								<h3 class="page-title">{{$title}}</h3>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
									@if(Auth::user()->role_id !== 1)
									<h5 style="margin-bottom: 30px ;">Active Team : <b> {{$team}} </b></h5>
									@endif
									@if(session()->has('success'))
									    <div class="alert alert-success alert-dismissible fade show">
									        {{ session()->get('success') }}
									    </div>
									@endif

									@if(session()->has('error'))
									    <div class="alert alert-danger alert-dismissible fade show">
									        {{ session()->get('error') }}
									    </div>
									@endif

									<form method="post" action="{{isset($data)?route('member.update',$data->id):route('member.store')}}">
										
									 <div class="row">
										@csrf
										 <div class="form-group col-6">
					                      <label for="">Region</label>
					                      <select name="region" id="region" class="form-control">
					                        <option value="">Select Region</option>
					                      @foreach($regions as $value)
					                        <option value="{{$value->id }}" {{isset($data) && $data->region_id==$value->id?'selected':''}} >{{strtoupper($value->region_name)}}</option>
					                       @endforeach
					                      </select>
					                      @error('region')
					                        <div class="alert alert-danger">{{ $message }}</div>
					                      @enderror
					                    </div>

					                    <div class="form-group col-6">
					                      <label for="">Country</label>
					                      <select name="region_country" id="region_country" class="form-control">
					                         @foreach($countries as $value)
					                        <option value="{{$value->id }}" {{isset($data) && $data->region_country==$value->id?'selected':''}} >{{ucfirst($value->name)}}</option>
					                       @endforeach
					                      </select>
					                      @error('region_country')
					                        <div class="alert alert-danger">{{ $message }}</div>
					                      @enderror
					                    </div>

									  <div class="form-group col-6">
									    <label for="">First Name</label>
									    <input type="text" name="first_name" value="{{$data->first_name??''}}" class="form-control" placeholder="First Name" required>
									    @error('first_name')
    										<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									  </div>

									  <div class="form-group col-6">
									    <label for="">Last Name</label>
									    <input type="text" name="last_name" value="{{$data->last_name??''}}" class="form-control" placeholder="Last Name" required>
									    @error('last_name')
    										<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									  </div>

									  <div class="form-group col-6">
									  	<label style="width: 100%;" for="">Sex</label>
										  <div class="form-check form-check-inline">
											  <input name="gender" class="form-check-input" type="radio" id="male" value="male" {{isset($data) && $data->gender === 'male' ? 'checked' : 'checked'}}>
											  <label class="form-check-label" for="male">Male</label>
											</div>

											<div class="form-check form-check-inline">
											  <input name="gender" class="form-check-input" type="radio" id="female" value="female" {{isset($data) && $data->gender === 'female' ? 'checked' : ''}}>
											  <label class="form-check-label" for="female">Female</label>
											</div>

										</div>

									  <div class="form-group col-6">
									    <label for="">Date of Birth</label>
									    <input type="date" name="dob" placeholder="Date of Birth Number" value="{{$data->dob??''}}" class="form-control" required>
									    @error('dob')
    										<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									  </div>

									  <div class="form-group col-6">
									    <label for="">Street</label>
									    <input type="text" name="street" placeholder="Street" value="{{$data->street??''}}" class="form-control" required>
									    @error('street')
    										<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									  </div>

									  <div class="form-group col-6">
									    <label for="">Postal Code</label>
									    <input type="number" name="postal_code" placeholder="Postal Code" value="{{$data->postal_code??''}}" class="form-control" required>
									    @error('postal_code')
    										<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									  </div>

									  <div class="form-group col-6">
									    <label for="">City</label>
									    <input type="text" name="city" placeholder="City" value="{{$data->city??''}}" class="form-control" required>
									    @error('city')
    										<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									  </div>

					                    <div class="form-group col-6">
					                      <label for="">Country</label>
					                      <select name="country" id="" class="form-control" >
					                        <option value="">Select Country</option>
					                      @foreach($countries as $value)
					                        <option value="{{$value->id }}" {{isset($data) && $data->country==$value->id?'selected':''}} >{{ucfirst($value->name)}}</option>
					                       @endforeach
					                      </select>
					                      @error('country')
					                        <div class="alert alert-danger">{{ $message }}</div>
					                      @enderror
					                    </div>

									  <div class="form-group col-6">
									    <label for="">Email Address</label>
									    <input type="text" name="email" id="email" placeholder="Email Address" value="{{$data->email??''}}" class="form-control">
									    @error('email')
    										<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									  </div>
									  @if(!isset($data))
									  <div class="form-group col-6">
									    <label for="">Confirm Email Address</label>
									    <input type="text" name="email_confirmation" placeholder="Confirm Email Address" value="{{$data->email??''}}" class="form-control">
									    @error('email_confirmation')
    										<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									  </div>
									  @endif
									  <div class="form-group col-6">
									    <label for="">Mobile Number</label><br/>
									    <input type="tel" name="phone" placeholder="Mobile Number" value="{{$data->phone??''}}" class="form-control" id="inputMobile" required>
									    @error('phone')
    										<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									  </div>

									  @if(!isset($data))
									  <div class="form-group col-6">
									    <label for="">Password</label>
									    <input minlength="6" type="password" id="password" name="password" placeholder="Password" class="form-control">
									    @error('password')
    										<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									  </div>

									  <div class="form-group col-6">
									    <label for=""> Confirm Password</label>
									    <input minlength="6" type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control">
									    @error('password_confirmation')
    										<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									  </div>
									  @endif

									  <div class="form-group col-6">
					                      <label for="">Member Category</label>
					                      <select name="member_category" id="" class="form-control">
					                        <option value="">Select Member Category</option>
					                        <option value="TP" {{isset($data) && $data->member_category=='TP'?'selected':''}} >Tournament Player (TP)</option>
					                        <option value="STP" {{isset($data) && $data->member_category=='STP'?'selected':''}} >Senior Tournament Player (STP)</option>
					                        <option value="CP" {{isset($data) && $data->member_category=='CP'?'selected':''}} >Club Professional (CP)</option>
					                        <option value="CD" {{isset($data) && $data->member_category=='CD'?'selected':''}} >Club Director (CD)</option>
					                        <option value="AP/LE" {{isset($data) && $data->member_category=='AP/LE'?'selected':''}} >Associated person or legal entity (AP/LE)</option>
					                      </select>
					                      @error('member_category')
					                        <div class="alert alert-danger">{{ $message }}</div>
					                      @enderror
					                    </div>

					                    <div class="form-group col-6">
										  	<label style="width: 100%;" for="">Member of golf club</label>
											  <div class="form-check form-check-inline">
												  <input name="member_of_golf_club" class="form-check-input member_of_golf_club" type="radio" id="yesGolfClub" value="1" {{isset($data) && $data->member_of_golf_club == 1 ? 'checked' : ''}}>
												  <label class="form-check-label" for="yesGolfClub">Yes</label>
												</div>

												<div class="form-check form-check-inline">
												  <input name="member_of_golf_club" class="form-check-input member_of_golf_club" type="radio" id="noGolfClub" value="0" {{isset($data) && $data->member_of_golf_club == 0 ? 'checked' : 'checked'}}>
												  <label class="form-check-label" for="noGolfClub">No</label>
												</div>
											</div>

										@if(isset($data) && $data->member_of_golf_club == 1)
					                    <div class="form-group col-6" id="golf_member">
										    <label for="">Golf Club Name</label>
										    <input type="text" name="golf_club_name" placeholder="Golf Club Name" value="{{$data->golf_club_name??''}}" class="form-control">
										    @error('golf_club_name')
	    										<div class="alert alert-danger">{{ $message }}</div>
											@enderror
										  </div>
										  @else
										  <div class="form-group col-6" id="golf_member" style="display: none;">
										    <label for="">Golf Club Name</label>
										    <input type="text" name="golf_club_name" placeholder="Golf Club Name" value="{{$data->golf_club_name??''}}" class="form-control">
										    @error('golf_club_name')
	    										<div class="alert alert-danger">{{ $message }}</div>
											@enderror
										  </div>
										  @endif

										   <div class="form-group col-6">
										  	<label style="width: 100%;" for="">PGA Status</label>
											  <div class="form-check form-check-inline">
												  <input name="pga_status" class="form-check-input pga_status" type="radio" id="pga_status1" value="1" {{isset($data) && $data->pga_status == 1 ? 'checked' : ''}}>
												  <label class="form-check-label" for="pga_status1">Yes</label>
												</div>

												<div class="form-check form-check-inline">
												  <input name="pga_status" class="form-check-input pga_status" type="radio" id="pga_status2" value="0" {{isset($data) && $data->pga_status == 0 ? 'checked' : 'checked'}}>
												  <label class="form-check-label" for="pga_status2">No</label>
												</div>
											</div>

											@if(isset($data) && $data->pga_country == 1)
											<div class="form-group col-6" id="pga_country_container">
						                      <label for="">PGA Country</label>
						                      <select name="pga_country" id="pga_country" class="form-control">
						                         @foreach($countries as $value)
						                        <option value="{{$value->id }}" {{isset($data) && $data->pga_country==$value->id?'selected':''}} >{{ucfirst($value->name)}}</option>
						                       @endforeach
						                      </select>
						                      @error('pga_country')
						                        <div class="alert alert-danger">{{ $message }}</div>
						                      @enderror
						                    </div>
						                    @else
						                    <div class="form-group col-6" id="pga_country_container" style="display: none;">
						                      <label for="">PGA Country</label>
						                      <select name="pga_country" id="pga_country" class="form-control">
						                         @foreach($countries as $value)
						                        <option value="{{$value->id }}" {{isset($data) && $data->pga_country==$value->id?'selected':''}} >{{ucfirst($value->name)}}</option>
						                       @endforeach
						                      </select>
						                      @error('pga_country')
						                        <div class="alert alert-danger">{{ $message }}</div>
						                      @enderror
						                    </div>
						                    @endif

											<div class="form-group col-6">
										  	<label style="width: 100%;" for="">Tour Membership</label>
											  <div class="form-check form-check-inline">
												  <input name="tour_membership" class="form-check-input" type="radio" id="tour_membership1" value="1" {{isset($data) && $data->tour_membership == 1 ? 'checked' : 'checked'}}>
												  <label class="form-check-label" for="tour_membership1">Yes</label>
												</div>

												<div class="form-check form-check-inline">
												  <input name="tour_membership" class="form-check-input" type="radio" id="tour_membership2" value="0" {{isset($data) && $data->tour_membership == 0 ? 'checked' : ''}}>
												  <label class="form-check-label" for="tour_membership2">No</label>
												</div>
											</div>

									  <div class="form-group col-12">
									    <label for="">State Tour / Other Comment</label>
									    <textarea name="comment" placeholder="State Tour / Other Comment" class="form-control">{{$data->comment??''}}</textarea>
									   
									  </div>

									  <div class="form-group col-12">
										  <div class="form-check form-check-inline">
											  <input name="agree" class="form-check-input" type="checkbox" id="agree" value="agree">
											  <label class="form-check-label" for="agree">Accept Membership Rules &amp; Regulations</label>
											</div>
										</div>

			                        </div>
									  <a href="{{route('members.index')}}"><button type="button" class="btn btn-danger">Back</button></a>

									  <input type="submit" value="{{isset($data)?'Update':'Add'}} Member" class="btn btn-{{isset($data)?'success':'success'}}">
									</form>
								</div>
							</div>
						</div>
					</div>
				
				</div>			
			</div>
			<!-- /Main Wrapper -->
	</div>
@endsection 

@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		 var inputMobile = document.querySelector("#inputMobile");
		window.intlTelInput(inputMobile, {
		  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
		});

		$("form").validate({
		  rules: {
		  	region: {
		    	required: true
		    },
		     phone: {
		     	required: true
		     },
		  	region_country: {
		    	required: true
		    },
		    email: {
		      required: true,
		      email: true
		    },
		    email_confirmation: {
	            equalTo: '#email'
	        },
		    password: {
		      required: true
		    },
		    password_confirmation: {
	            equalTo: '#password'
	        },
		    country: {
		    	required: true
		    },
		    member_category: {
		    	required: true
		    },
		    golf_club_name: {
		    	required:'#yesGolfClub:checked'
		    },
		    pga_country: {
		    	required:'#pga_status1:checked'
		    }
		  }
		});

		$(':input[type="submit"]').prop('disabled', true);
		$('.member_of_golf_club').click(function() {
		   var radioValue = $("input[name='member_of_golf_club']:checked").val();
            if(radioValue === '1'){
                $('#golf_member').show();
            }else{
            	$('#golf_member').hide();
            }
		});

		$('.pga_status').click(function() {
		   var radioValue = $("input[name='pga_status']:checked").val();
            if(radioValue === '1'){
                $('#pga_country_container').show();
            }else{
            	$('#pga_country_container').hide();
            }
		});

		$('#agree').click(function() {
		   var agreeValue = $("input[name='agree']:checked").val();
            if(agreeValue === 'agree'){
                $(':input[type="submit"]').prop('disabled', false);
            }else{
            	$(':input[type="submit"]').prop('disabled', true);
            }
		});

		$('#region').on('change', function() {
		   var region = $(this).val();
            if(region === '1'){
            	$("#region_country option[value='209']").remove();
                var option = "<option value='209' selected>South Africa</option>"
            }else if(region === '2'){
            	$("#region_country option[value='14']").remove();
                var option = "<option value='14' selected>Australia</option>"
            }else if(region === '3'){
            	$("#region_country option[value='218']").remove();
                var option = "<option value='218' selected>Sweden</option>"
            }else if(region === '4'){
            	$("#region_country option[value='224']").remove();
                var option = "<option value='224' selected>Thailand</option>"
            }else if(region === '5'){
            	$("#region_country option[value='239']").remove();
                var option = "<option value='239' selected>USA</option>"
            }else if(region === '6'){
            	$("#region_country option[value='253']").remove();
                var option = "<option value='253' selected>England</option>"
            }else if(region === '7'){
            	$("#region_country option[value='11']").remove();
                var option = "<option value='11' selected>Argentina</option>"
            }else if(region === '8'){
            	$("#region_country option[value='83']").remove();
                var option = "<option value='83' selected>Germany</option>"
            }else if(region === '9'){
            	$("#region_country option[value='112']").remove();
                var option = "<option value='112' selected>Japan</option>"
            }

            $("#region_country").prepend(option);
		});
	})
</script>
@endsection