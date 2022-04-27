
@extends('layouts.apps')

@section('content')

@extends('layouts.table')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>List Of Invoices</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Invoices</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Invoices</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr.</th>
                    <th>Serial Number</th>
                    <th>Name</th>
                    <th>Invoice Number</th>
                    <th>Price</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data as $key=>$item)

                  <tr>
                    <td>{{++$key}}</td>
                    <td>#000{{$item->id}}
                    </td>
                    <td>{{$item->customer->name}}</td>
                    <td>{{$item->invoice_number}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{ Carbon\Carbon::parse($item->start_date)->format('Y-m-d') }}</td>
                    <td>{{ Carbon\Carbon::parse($item->end_date)->format('Y-m-d') }}</td>
                      <td class="project-actions" >
                          <a class="btn btn-primary btn-sm" href="{{url('admin/invoices/show', $item->id) }}">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </a>
                         
                      </td>
                  </tr>
                  @endforeach
                  
               
                  </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection('content')