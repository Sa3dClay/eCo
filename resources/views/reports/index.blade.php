@extends('layouts.app')

@section('content')

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Reports</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="container">
    <p>All reports that <b> you haven't seen them</b></p>
    <table class="table table-hover">
      <thead>
        <tr>
          <th style="color: #1ABC9C">User id</th>
          <th style="color: #1ABC9C">report</th>
          <th style="color: #1ABC9C">created at</th>
          <th style="color: #1ABC9C">Have you seen it?</th>
        </tr>
      </thead>
      <tbody>
        @foreach($reports as $report)
            <tr>
              <td>{{$report->user_id}}</td>
              <td>{{$report->message}}</td>
              <td>{{$report->created_at}}</td>
              <td>{!! Form::open(['action' => ['ReportController@destroy',$report->id],'method'=>'POST']) !!}
                      {{Form::hidden('_method','DELETE')}}
                      {{Form::submit('Mark as seen',['id'=>'remove-submit','style'=>'border-radius:5px'])}}
                  {!! Form::close() !!}</td>
            </tr>
        @endforeach
      </tbody>
    </table>
</div>
@endsection
