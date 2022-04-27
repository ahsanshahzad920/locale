@extends('layouts.apps')
@section('')
<style>
.text-black{
color: #1f2d3d!important;
}
</style>
@endsection
@section('content')


<div class="wrapper">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add FeedBack</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add FeedBack</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">FeedBack</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{url('admin/feedback/store')}}" method="post">
                <div class="card-body">
                     <!--  -->
                     <div>
                        <div class="repeater-head">

                            <div class="row mx-0 repeater">
                                <div class="col-12">
                                    <label>Question <span></span> </label>
                                </div>

                                
                                <div class="col-7 ">
                                    <div class="form-group">
                                        <input type="text" name="question[]" class="form-control" id=""
                                            aria-describedby="" placeholder="Enter Question">
                                    </div>
                                </div>
                                <div class="col-4 ">
                                    <div class="form-group">
                                        <select class="form-control" multiple="multiple" data-placeholder="Select a Option" id="exampleFormControlSelect1" name="option[]"> 
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <p class="delete text-black"><span class="fa fa-times fa-lg"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <span class="add text-black" style="color:black;">
                                <p class="fa fa-plus"></p> Add Phone
                            </span>
                        </div>
                    </div>
                     <!--  -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
    
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</div>


    
    
   
    
@endsection('content')
@section('scripts')
<script>
        $(".add").on('click', function() {
         // alert('dsa');
            $('.repeater:last-child').clone(true).appendTo('.repeater-head');
            // to make the clone removable, set clone(true)
        });
        $('.delete').on('click', function(event) {
            $(this).parents('.repeater').remove();
        });
    </script>
@endsection