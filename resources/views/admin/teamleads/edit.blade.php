@extends('layouts.app')

@section('content')


<div class="container">
    <h3>Add Team Lead</h3>
   
    <form action="{{url("admin/teamleads/update/".$data->id)}}" method="post">
    <div class="form-group">
        <label for="">User Name</label>
        <input required type="text" class="form-control" name="name" value="{{$data->name}}"/>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input required  type="email" class="form-control" name="email" value="{{$data->email}}"/>
    </div>
    <div class="form-group">
    <button class="btn btn-primary btn-lg">Update</button>    
    </div>
    </form>
</div>
@endsection
