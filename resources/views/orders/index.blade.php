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
              <th>Shipping</th>
              <th>cancelling</th>
            </thead>

            <tbody>
              @if (!empty($orders))
                @foreach ($orders as $order)

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
              <th>status</th>
            </thead>

            <tbody>
              @if (!empty($orders))
                @foreach ($orders as $order)

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
