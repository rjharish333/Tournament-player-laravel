@extends('layout.mainlayout')
@section('content')	

<div class="page-wrapper">
			<div class="content container-fluid">
			
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title"><i class="{{$icon}}" style="color: #518c68"></i> Regions</h3>
						</div> 
					</div>
				</div>
				<!-- Page Header -->
				        
				<!-- table -->
				<div class="row">
					<div class="col-12">
						<a href="{{url("/region/create")}}"><button class="mb-3 btn btn-primary float-right" style="margin-left:10px"><i class="fa fa-plus" aria-hidden="true"></i> Add Region</button></a>
						
					@if(session()->has('success'))
					    <p class="alert alert-success alert-dismissible fade show">{{ Session::get('success') }}</p>
					@endif

					@if(session()->has('error'))
					    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
					@endif

	                  <table id="" class="display table dataTable table-striped table-bordered" >
	                     <thead>
	                        <tr>
		                        <th scope="col">#</th>
		                        <th scope="col">REGION NAME</th>
		                        <th scope="col">STATUS</th>
		                        <th scope="col">ACTION</th>
		                     </tr>
	                     </thead>
	                     <tbody>
	                     	@if(count($data) > 0)
	                     	@foreach($data as $key => $value)
	                  

		                     <tr>
		                        <td>{{ $data->firstitem() + $key }}</td>
		                        <td>{{ucfirst($value->region_name)}}</td>
			                    <td>
		                        	{{$value->status===1?'Active':'Inactive'}}
		                        </td>
		                        <td>
		                        	
		                        	<a href="{{route('region.edit', $value->id)}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
		                        	<a onclick="return confirm('Are you sure you want to delete?');" href="{{route('region.destroy', $value->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
		                        	
		                        </td>
		                     </tr>
		                     @endforeach
	                     	@else
                                <tr>
                                    <td colspan="5">No Regions Found</td>
                                </tr>
                            @endif
                            </tbody>
                            <tfoot>
	                           <tr>
		                        <th scope="col">#</th>
		                        <th scope="col">REGION NAME</th>
		                        <th scope="col">STATUS</th>
		                        <th scope="col">ACTION</th>
		                     </tr>
	                        </tfoot>
                        </table>
                        
                        {{ $data->appends(request()->except('page'))->links() }}
					</div>
				</div>
			</div>
		</div> 
	</div>
	
@endsection 

@section('scripts')	

@endsection