@extends('layout.mainlayout')
@section('content') 
<div class="page-wrapper">
      <div class="content container-fluid">
      
        <!-- Page Header -->
          <div class="page-header">
            <div class="row">
              <div class="col">
                <h3 class="page-title"><i class="{{$icon}}" style="color: #518c68"></i> Send Email</h3></h3>
              </div>
            </div>
          </div>
          <!-- /Page Header -->
          
          <div class="row">
            
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-body">
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

                  <form method="post" action="{{route('email.send')}}">
                    @csrf

                    <div class="form-group col-6">
					  	<label style="width: 100%;" for="">Email Send Type</label>
						  <div class="form-check form-check-inline">
							  <input name="email_send_type" class="form-check-input email_Send" type="radio" id="all_email" value="all">
							  <label class="form-check-label" for="all">Send Email to all users</label>
							</div>

							<div class="form-check form-check-inline">
							  <input name="email_send_type" class="form-check-input email_Send" type="radio" id="team_email" value="team_email" checked>
							  <label class="form-check-label" for="team_email">Send to specific team</label>
							</div>

						</div>

                     <div class="form-group col-6 team_section">
                      <label for="">Team</label>
                      <select name="team" id="" class="form-control">
                        <option value="">Select Team</option>
                      @foreach($teams as $value)
                        <option value="{{$value->id }}" >{{strtoupper($value->team_name)}}</option>
                       @endforeach
                      </select>
                      @error('team')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div> 

                    <div class="form-group col-6">
					    <label for="">Subject</label>
					    <input type="text" name="subject" placeholder="Email Subject" class="form-control" required>
					    @error('subject')
							<div class="alert alert-danger">{{ $message }}</div>
						@enderror
					  </div>

					  <div class="form-group col-6">
					    <label for="">Message</label>
					    <textarea name="message" placeholder="Email Message" class="form-control" required></textarea>
					    @error('message')
							<div class="alert alert-danger">{{ $message }}</div>
						@enderror
					  </div>



                    <a href="{{route('teams.index')}}"><button type="button" class="btn btn-danger"> < Back</button></a>

                    <input type="submit" value="Send Email" class="btn btn-{{isset($data)?'success':'primary'}}">
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
		$("form").validate();
		$('.email_Send').click(function() {
			   var radioValue = $("input[name='email_send_type']:checked").val();
	            if(radioValue === 'all'){
	                $('.team_section').hide();
	            }else{
	            	$('.team_section').show();
	            }
			});
	})
</script>
@endsection