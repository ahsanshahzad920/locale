@extends('layouts.app')
@section('content')

<div class="alert h3 text-center shadow">
  My Projects


</div>

<div class="container-fluid mt-4">
  
  <div class="row mt-1">
      <div class="col-lg-10" >
        
        <div class="w-100 " style="max-height:80vh; overflow-y:scroll">
          @if(sizeof($data) > 0)

          <div class="w-100 d-flex">
            <div class="w-50 p-1">
             
            </div>
            <div class="input-group mb-3 w-50 px-4">
              <input type="text" class="form-control" placeholder="Search Ticket">
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Search</button>
              </div>
            </div>
           
          </div>

<!-- Page wrapper/Container Section -->
<div class="row w-100">
  @foreach($data as $key=>$item)

  <div class="col-lg-4 col-sm-6 col-12 p-lg-3">
    <div class="card shadow w-100 text-dark">
      <div class="card-header bg-white">
       <div classs="w-100"> 
         <h4>{{$item->title}}
          <div class="dropdown float-lg-right">
            <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton{{$item->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="{{url('teamlead/project/messages/'.$item->id.'/'.$item->invoice_number)}}">Inbox</a>
              <a class="dropdown-item" href="#">View Details</a>
              <a class="dropdown-item" href="#">Delete</a>
            </div>
          </div>
        </h4>
          <span># {{$item->invoice_number}}</span>
         <div class="w-100 text-small">
           
         <span class="badge badge-primary">{{$item->status}}</span>
         <span class="float-right text-align-right">{{date("d M,Y h:i A", strtotime($item->created_at))}}</span>
        </div>
       </div>
      </div>

      <div class="card-body text-dark" style="mix-height: 300px">
       <span style="float: left"> {{substr($item->description, 0, 20)}} ..</span>
      
      </div>

     
      </div>
    </div>

  @endforeach
 
</div>
@else
<div class="alert w-100 text-danger text-center text-bold">
  No Project Found !
</div>
@endif

        </div>

      </div>
      <div class="col-lg-2 bg-light py-2" style="max-height:80vh; overflow-y:scroll">
      

        <a href="{{url('user/projects?status=requested')}}" class="d-flex">
          <p class="text-info " style="flex: 2;"> Opened Tickets</p>
          <p style="flex: 1;"> 
          <span class="text-bold badge badge-info  text-white p-2" >
            {{sizeof(\App\Models\Project::getProjectByStatus(Auth::id(), ["requested"]))}}
          </span>
        </p>
        </a>
        <a href="{{url('user/projects?status=offer_accepted')}}" class="d-flex">
          <p class="text-info " style="flex: 2;"> Hired Tickets</p>
          <p style="flex: 1;"> 
          <span class="text-bold badge badge-info  text-white p-2" >
            {{sizeof(\App\Models\Project::getProjectByStatus(Auth::id(), ["offer_accepted"]))}}
          </span>
        </p>
        </a>
        <a href="{{url('user/projects?status=completed')}}" class="d-flex">
          <p class="text-success " style="flex: 2;"> Completed Tickets</p>
          <p style="flex: 1;"> 
          <span class="text-bold badge badge-success  text-white p-2" >
            {{sizeof(\App\Models\Project::getProjectByStatus(Auth::id(), ["completed"]))}}

          </span>
        </p>
        </a>
        <a href="{{url('user/projects?status=closed')}}" class="d-flex">
          <p class="text-danger " style="flex: 2;"> Closed Tickets</p>
          <p style="flex: 1;"> 
          <span class="text-bold badge badge-danger  text-white p-2" >
            {{sizeof(\App\Models\Project::getProjectByStatus(Auth::id(), ["closed"]))}}
          </span>
        </p>
        </a>
        <a href="{{url('user/projects?status=requested')}}" class="d-flex">
          <p class="text-primary " style="flex: 2;"> Pending Tickets</p>
          <p style="flex: 1;"> 
          <span class="text-bold badge badge-primary  text-white p-2" >
            {{sizeof(\App\Models\Project::getProjectByStatus(Auth::id(), ["requested"]))}}

          </span>
        </p>
        </a>
       
        <br><br><br>

       
        </div>
      </div>

    </div>
  </div>
@endsection