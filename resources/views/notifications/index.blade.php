@extends('layouts.app')

@section('content')

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Notifications</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="container">
    <table class="table table-hover">
      <thead>
        <tr>
          <th style="color: #1ABC9C"> </th>
        </tr>
      </thead>
      <tbody>
        @if(isset($notifications))
          @foreach($notifications as $notification)
              <tr>
                <td>
                  <i class="glyphicon glyphicon-envelope"> </i>
                  <b>{{$notification->title}}</b>
                
                {{$notification->message}}.
                
                <i class="glyphicon glyphicon-time"> {{$notification->created_at}}</i>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
</div>
@endsection
