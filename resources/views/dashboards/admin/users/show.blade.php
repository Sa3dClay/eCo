@extends('layouts.app')

@section('content')
  <div class="container">
	  <div class="row">
      <div class="col-md-12">
        <h2 class="usersHeader">Users Lists</h2>

        @if (session('success'))
          <p class="alert alert-success">{{session('success')}}</p>
        @endif

        @if (session('danger'))
          <p class="alert alert-danger">{{session('danger')}}</p>
        @endif

        <div class="table-responsive">
          <table id="mytable" class="table table-bordred table-striped">
            <thead>
              <th>Name</th>
              <th>Email</th>
              <th>Created</th>
              <th>Block status</th>
              <th>Delete</th>
            </thead>
            
            <tbody>
              @if (!empty($users))
                @foreach ($users as $user)
                  <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->created_at}}</td>

                    <td>
                      <form method="POST" action="{{url('dashboard/admin/blockuser')}}">
                        @csrf
                        <input type="text" hidden name="user_id" value="{{$user->id}}"/>
                        <button type="submit" class="btn btn-warning btn-md">{{$user->blocked ? "Unblock": "Block"}}</button>
                      </form>
                    </td>

                    <td>
                      <form method="POST" action="{{url('dashboard/admin/deleteuser')}}">
                        @csrf
                        <input type="text" hidden name="user_id" value="{{$user->id}}"/>
                        <button type="submit" class="btn btn-danger btn-md" ><span class="glyphicon glyphicon-trash"></span></button>
                      </form>
                    </td>
                  </tr>
                @endforeach  
              @endif
    
            </tbody>
          </table>

          <div class="clearfix"></div> 
        </div>
      </div>
	  </div> <!-- End Row -->
  </div> <!-- End Container -->

  <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
          <h4 class="modal-title custom_align" id="Heading">Block Status</h4>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to take this action?</div>
        </div>
        <div class="modal-footer ">
          <form method="POST" action="{{url('dashboard/admin/blockuser')}}">
            @csrf
            <input type="text" hidden name="user_id" id="user_id" value=""/>
            <button type="submit" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content --> 
    </div>
    <!-- /.modal-dialog --> 
  </div>
    
  <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
          <h4 class="modal-title custom_align" id="Heading">Delete this user</h4>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this User?</div>
        </div>
        <div class="modal-footer ">
          <form method="POST" action="{{url('dashboard/admin/deleteuser')}}">
            @csrf
            <input type="text" hidden name="user_id" id="user_id" value=""/>
            <button type="submit" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content --> 
    </div>
    <!-- /.modal-dialog --> 
  </div>

@endsection
