@extends('layouts.app')

@section('content')
<div class="alert">
    <a href="{{url("admin/teamleads/create")}}"
    class="btn btn-primary">
    Add a team lead
    </a>
</div>
<div class="container">
    <h3>Team Leads</h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>Sr</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>
                        Actions
                    </td>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $key=>$item)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->email}}</td>
                    <td>
                        <a href="{{url('admin/teamleads/edit/'.$item->id)}}" class="btn btn-success">
                        edit
                        </a>

                        <a href="javascript:void(0)"
                        onclick="document.getElementById('deleteForm{{$item->id}}').submit()"
                        class="btn btn-danger">
                            delete
                            </a>
                            <form 
                            id="deleteForm{{$item->id}}"
                            action="{{url('admin/teamleads/delete/'.$item->id)}}" method="post">
                            </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
     
    </div>
</div>
@endsection
