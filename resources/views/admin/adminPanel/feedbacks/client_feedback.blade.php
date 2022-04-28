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
                                <form action="{{ url('admin/client_feedback') }}" method="post">
                                    @csrf
                                    <div class="card-body">
                                        <!--  -->
                                        {{-- {{dd($data)}} --}}
                                        <div class="row mx-0 repeater">
                                            @foreach($data['question'] as $index=> $item)
                                            <div class="col-12">
                                                <label>Question <span></span> </label>
                                            </div>
                                            

                                            <div class="col-12 ">
                                                <div class="form-group">
                                                    <input type="hidden" name="question[]" value="{{$item}}">
                                                    <p>{{$item}}</p>
                                                    
                                                </div>
                                            </div>
                                            @if(in_array("1",$data['option'.$index]))
                                            <div class="col-12 ">
                                                <b>Option 1</b>
                                                <div class="form-group">
                                                    <input type="radio" name="option1{{$index}}" value="0" id="">
                                                    <label for="">Yes</label>
                                                    <input type="radio" name="option1{{$index}}" value="1" id="">
                                                    <label for="">No</label>
                                                </div>
                                            </div>
                                            @endif
                                            @if(in_array("2",$data['option'.$index]))
                                            <div class="col-12 ">
                                                <b>Option 2</b>
                                                <div class="form-group">
                                                    <input type="radio" name="option2{{$index}}" value="1" id="">
                                                    <label for="">1</label>
                                                    <input type="radio" name="option2{{$index}}" value="2" id="">
                                                    <label for="">2</label>
                                                    <input type="radio" name="option2{{$index}}" value="3" id="">
                                                    <label for="">3</label>
                                                    <input type="radio" name="option2{{$index}}" value="4" id="">
                                                    <label for="">4</label>
                                                    <input type="radio" name="option2{{$index}}" value="5" id="">
                                                    <label for="">5</label>
                                                    <input type="radio" name="option2{{$index}}" value="6" id="">
                                                    <label for="">6</label>
                                                    <input type="radio" name="option2{{$index}}" value="7" id="">
                                                    <label for="">7</label>
                                                    <input type="radio" name="option2{{$index}}" value="8" id="">
                                                    <label for="">8</label>
                                                    <input type="radio" name="option2{{$index}}" value="9" id="">
                                                    <label for="">9</label>
                                                    <input type="radio" name="option2{{$index}}" value="10" id="">
                                                    <label for="">10</label>
                                                </div>
                                            </div>
                                            @endif
                                            @if(in_array("3",$data['option'.$index]))
                                            <div class="col-12 ">
                                                <b>Option 3</b>
                                                <div class="form-group">
                                                    <input type="radio" name="option3{{$index}}" value="0" id="">
                                                    <label for="">Yes</label>
                                                    <input type="radio" name="option3{{$index}}" value="1" id="">
                                                    <label for="">Not</label>
                                                </div>
                                            </div>
                                            @endif
                                            @if(in_array("4",$data['option'.$index]))
                                            <div class="col-12 ">
                                                <b>Option 4</b>
                                                <div class="form-group">
                                                    <label for="">Comment</label>
                                                    <input type="text" class="form-control" name="option4{{$index}}" value="{{old('option4')}}" id="">
                                                    
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
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
@endsection
