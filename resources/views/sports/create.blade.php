@extends('layout.mainlayout')
@section('content') 
<div class="page-wrapper">
      <div class="content container-fluid">
      
        <!-- Page Header -->
          <div class="page-header">
            <div class="row">
              <div class="col">
                <h3 class="page-title"><i class="{{$icon}}" style="color: #518c68"></i> {{isset($data)?'Update':'Add'}} Sport</h3></h3>
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

                  <form method="post" action="{{isset($data)?route('sport.update', [$data->id]):route('sport.store')}}">
                    @csrf

                    <div class="form-group">
                      <label for="">Sport Name</label>
                      <input type="text" name="sport" placeholder="Sport Name" value="{{$data->sport_name??''}}" class="form-control">
                      @error('sport')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>  

                    <a href="{{route('sports.index')}}"><button type="button" class="btn btn-danger"> < Back</button></a>

                    <input type="submit" value="{{isset($data)?'Update':'Add'}} Sport" class="btn btn-{{isset($data)?'success':'primary'}}">
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
