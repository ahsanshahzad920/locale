@extends('layouts.apps')
@section('')
    <style>
        .text-black {
            color: #1f2d3d !important;
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
                                @if (session('success'))
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                            @endif
                                            @if (session('error'))
                                                <div class="alert alert-danger">
                                                    {{ session('error') }}
                                                </div>
                                            @endif
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="{{ url('admin/feedback/store') }}" method="post">
                                    <div class="card-body">
                                        <!--  -->
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
                                                    <select class="form-control" name="option0[]" multiple="multiple"
                                                        data-placeholder="Select a Option" id="exampleFormControlSelect1">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>

                                                    </select>
                                                    {!! $errors->first('option0', "<span class='text-danger'>:message</span>") !!}
                                                </div>
                                            </div>
                                            <div class="col-12 new">

                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <span class="add text-black" style="color:black;">
                                                <p class="fa fa-plus"></p> Add Question
                                            </span>&nbsp;
                                            <span class="delete text-black" style="color:black;">
                                                <p class="fa fa-times"></p> Remove
                                            </span>
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
        $(document).ready(function() {
            $(".add").on("click", function() {
                const count = document.querySelectorAll('#option').length;
                $(".new").append(
                    "<div class='row'><div class='col-7'><div class = 'form-group'><input type = 'text' name = 'question[]' class = 'form-control' id = ' aria-describedby=' placeholder = 'Enter Question'></div> </div> <div class = 'col-4 ' ><div class = 'form-group'><select class = 'form-control' name = 'option" +
                    (count + 1) +
                    "[]' id='option' multiple = 'multiple' placeholder = 'Select a Option'> <option value = '1' > 1 </option> <option value = '2' > 2 </option> <option value = '3' > 3 </option> <option value = '4' > 4 </option> </select> </div> </div></div>"
                );
            });
            $(".delete").on("click", function() {
                $(".new").children().last().remove();
            });
        });
    </script>
@endsection
