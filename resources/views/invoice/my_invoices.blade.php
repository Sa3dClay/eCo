@extends('layouts.app')

@section('content')

  <div class="container">
	  <div class="row">
      <div class="col-md-12">
        <h2 class="usersHeader">My Orders</h2>

        <div class="table-responsive">
          <table id="mytable" class="table table-bordred table-striped">
            <thead>
              <th>Order info.</th>
              <th>Address</th>
              <th>status</th>
            </thead>

            <tbody>
              @if (!empty($invoices))
                @foreach ($invoices as $invoice)
                    <tr>
                      <td><a href="{{ route('order_info',[$invoice->id]) }}"><i class="glyphicon glyphicon-arrow-right"></i> Order {{$invoice->id}}</a></li></td>
                      <td>{{\App\Http\Controllers\InvoiceController::get_user_address($invoice->id)}}</td>
                      <td>
                        {{$invoice->status}}
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

@endsection
