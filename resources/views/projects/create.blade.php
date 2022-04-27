@extends('layouts.app')

@section('content')

<form class="container shadow-lg my-2 px-5  py-5 php-email-form" method="post" 
action="{{url('user/project')}}" 
enctype="multipart/form-data">
    @csrf
    <h3 class="mb-5">Post a project</h3>
    <div class="row">

      <div class="col-lg-6">
        <div class="form-group">
          <label>Title *</label>
          <input class="form-control" name="title" placeholder="enter the project title" required/> 
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label>Department *</label>
          <select onchange="ifValueIsOther(this.value)" name="department" class="form-control" placeholder="enter the project title" required>
          <option>Arts</option>  
          <option>Business and Accounting</option>  
          <option>Creative Writing</option>  
          <option>Engineering</option>  
          <option>IT and Security</option>  
          <option>Law</option>  
          <option>Medical</option>  
          <option>Research Papers</option>  
          <option>Social Sciences</option>  
          <option>Sociology/History</option>  
          <option>Technology</option>  
          <option>Other</option>
          </select>

        </div>
        <div class="form-group my-2" >
          <input id="other" name="department" class="form-control" style="display:none" placeholder="describe subject">
        </div>
      </div>


      <div class="col-lg-6">
        <div class="form-group">
          <label>Course name *</label>
          <input class="form-control" name="course_name" placeholder="enter the course name" required/> 
        </div>
      </div>

      
      <div class="col-lg-6">
        <div class="form-group">
          <label>Attach documents</label><br>
          <label class=""> 
            <input class="form-control " type="file" name="document"  /> 
            </label>
        </div>
      </div>

      <div class="col-lg-12">
        <div class="form-group">
          <label>Description *</label>
          <textarea class="form-control" name="description" placeholder="enter the description" required></textarea> 
        </div>
      </div>

      <div class="mt-2 col-lg-6">
        <button class="btn btn-primary">Start the project</button>
      </div>



    </div>
  </form>


@endsection