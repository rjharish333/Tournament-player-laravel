@extends('layout.mainlayout')
@section('content')	
<div class="page-wrapper">
			<div class="content container-fluid">
			
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title"><i class="fa fa-key" style="color: #518c68"></i> Change Password</h3>
						</div> 
					</div>
				</div>
		<div class="row">
		    <div class="col-12"><br />&nbsp;<br />&nbsp;
				<!-- /Page Header -->
				<form method="POST" action="{{ route('postpassword.change') }}">
          @csrf
          @if(Session::has('success'))
					<p class="alert alert-success">{{ Session::get('success') }}</p>
					@endif
            <div class="form-group row">
               	<label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
                <div class="col-md-6">
                    <input type="password" placeholder="New Password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="password">
                    @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password Confirmation</label>
                <div class="col-md-6">
                    <input type="password" placeholder="Confirm New Password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="password_confirmation">
                    @error('password_confirmation')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Change Password
                    </button>
                </div>
            </div>
        </form>
			</div>
		</div> 
		</div> </div>
	</div>

@endsection

