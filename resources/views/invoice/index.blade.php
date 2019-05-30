@extends('layouts.app')

@section('content')
  <div class="container">
	  <div class="row">
      <div class="col-md-12">
        <h2 class="usersHeader">New Orders</h2>

      <!--  @//if (session('success'))
          <p class="alert alert-success">{//{session('success')}}</p>
        @//endif

        @//if (session('danger'))
          <p class="alert alert-danger">{//{session('danger')}}</p>
        @//endif -->

        <div class="table-responsive">
          <table id="mytable" class="table table-bordred table-striped">
            <thead>
              <th>Order info.</th>
              <th>Address</th>
              <th>Ship the order</th>
              <th>cancel the order</th>
            </thead>

            <tbody>
              @if (!empty($invoices))
                @foreach ($invoices as $invoice)
                  @if($invoice->status=='new')
                    <tr>
                      <td><a href="{{ route('order_info',[$invoice->id]) }}"><i class="glyphicon glyphicon-arrow-right"></i> Order {{$invoice->id}}</a></li></td>
                      <td>{{\App\Http\Controllers\InvoiceController::get_user_address($invoice->id)}}</td>
                      <td>
                        <form method="POST" action="{{route('set_status',[$invoice->id,'shipping'])}}">
                          @csrf
                          <button type="submit" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-plane"> Start-Shipping</span></button>
                        </form>
                      </td>

                      <td>
                        <form method="POST" action="{{route('set_status',[$invoice->id,'canceled'])}}">
                          @csrf
                          <button type="submit" class="btn btn-danger btn-md" ><i class="glyphicon glyphicon-remove-sign"></i> cancel</span></button>
                        </form>
                      </td>
                    </tr>
                  @endif
                @endforeach
              @endif

            </tbody>
          </table>

          <div class="clearfix"></div>
        </div>
      </div>
	  </div> <!-- End Row -->
  </div> <!-- End Container -->

  <div class="container">
	  <div class="row">
      <div class="col-md-12">
        <h2 class="usersHeader">Other Orders</h2>

        <div class="table-responsive">
          <table id="mytable" class="table table-bordred table-striped">
            <thead>
              <th>Order info.</th>
              <th>Address</th>
              <th>status</th>
              <th>change status</th>
            </thead>

            <tbody>
              @if (!empty($invoices))
                @foreach ($invoices as $invoice)
                  @if($invoice->status!='new')
                    <tr>
                      <td><a href="{{ route('order_info',[$invoice->id]) }}"><i class="glyphicon glyphicon-arrow-right"></i> Order {{$invoice->id}}</a></li></td>
                      <td>{{\App\Http\Controllers\InvoiceController::get_user_address($invoice->id)}}</td>
                      <td>
                        {{$invoice->status}}
                      </td>

                      <td>
                        @if($invoice->status=='shipping')
                          <form method="POST" action="{{route('set_status',[$invoice->id,'shipped'])}}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-md" ><i class="glyphicon glyphicon-thumbs-up"></i> shipped</span></button>
                          </form>
                        @elseif($invoice->status=='canceled')
                          <form method="POST" action="{{route('set_status',[$invoice->id,'new'])}}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-md" ><i class="glyphicon glyphicon-repeat"></i> uncancel</span></button>
                          </form>
                        @endif
                      </td>
                    </tr>
                  @endif
                @endforeach
              @endif

            </tbody>
          </table>

          <div class="clearfix"></div>
        </div>
      </div>
	  </div> <!-- End Row -->
  </div> <!-- End Container -->

@endsection
