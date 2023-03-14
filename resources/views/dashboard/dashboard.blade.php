@extends('layout.mainlayout')
@section('content')	

<div class="page-wrapper">
    <div class="content container-fluid">

    	<!-- Page Header -->
    	<div class="page-header">
    		<div class="row">
    			<div class="col">
    				<h3 class="page-title"><i class="fas fa-university" style="color: #518c68"></i> Dashboard</h3>
    			</div> 
    		</div>
    	</div>
    	<!-- /Page Header -->

        <!-- Card stats -->

        <div class="row">

            <div class="col-md-12 col-sm-6 mt-3">
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

                  @if($user->role_id !== 1)
                  <form method="post" action="{{route('dashboard.team.update')}}">
                    @csrf

                     <div class="form-group">
                      <label for="">Team</label>
                      <select name="team" id="" class="form-control">
                        <option value="all">All</option>
                      @foreach($teams as $value)
                        <option value="{{$value->id}}" {{isset($user) && $user->active_team==$value->id?'selected':''}} >{{$value->team_name}}</option>
                       @endforeach
                      </select>
                      @error('team')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <input type="submit" value="Activate Team" class="btn btn-{{isset($user)?'success':'primary'}}">
                  </form>
                  @endif                            
                    </div>
                </div>
            </div>
                
        </div>
        
        <div>
    </div>