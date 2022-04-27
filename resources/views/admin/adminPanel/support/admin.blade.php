
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
            <h1>List Of Support</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admin Support</li>
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
                <h3 class="card-title">List of Admin Support</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr.</th>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data as $key=>$item)

                  <tr>
                    <td>{{++$key}}</td>
                    <td>{{$item->sender->email}}
                    </td>
                    <td>{{$item->titile}}</td>
                    <td>{{$item->message}}</td>
                    <td class="project-actions">
                          <!-- <a data-toggle="modal" data-id="{{$item->sender_id}}" data-target="#exampleModal" class="btn btn-primary btn-sm" onclick="assessmentDelete{{ $item->id }}({{ $item->sender_id}})">
                              <i class="fas fa-folder">
                              </i>
                              Reply
                          </a> -->
                          
                    </td>
                  </tr>
                  @endforeach
                  
               
                  </tbody>
                  
                </table>
              </div>
              <!--  -->
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Reply</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{url('admin/support/store')}}" method="post">
                        <div class="modal-body">
                          <input type="hidden" name="receiver_id" id="receiver_id">
                          <input type="hidden" name="titile" id="titile" value="Errors report">
                          <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="message"></textarea>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                  </div>
                </div>
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
@section('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.0/tinymce.min.js"></script>
@foreach ($data as $item)
    <script>
        function assessmentDelete{{ $item->id }}(id) {
         // console.log($(this).data("id"));
          console.log(id);
         $('#receiver_id').val(id);
         //$('#receiver_id').val(e);

        }
    </script>
@endforeach
@endsection        