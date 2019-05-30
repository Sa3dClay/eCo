@extends('layouts.app')

@section('content')

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>My account</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        {!! Form::open(['action' => ['UserController@update'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        {{Form::label('name', 'Name')}}
                        {{Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
                    </div>
                </div>
            </div>
            <div class = "row">
                <div class="col-md-2">
                    <div class="form-group">
                        {{Form::label('email', 'Email')}}
                        @if(isset($user->email_verified_at))
                          <i class="glyphicon glyphicon-ok-sign" style="float:right;"><b>Verified</b></i>
                        @else
                          <i class="glyphicon glyphicon-remove-sign" style="float:right;"><b>Not-Verified</b></i>
                        @endif
                        </br>
                        <b style="padding-left: 15px;"> {{$user->email}} </b>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {{Form::label('phone_number', 'Phone number')}}
                        {{ Form::number('phone_number',$user->phone_number,['class'=>'form-control','placeholder'=>'Phone number']) }}
                    </div>
                </div>
            </div>

            <div class = "row">
                <div class="col-md-9">
                    <div class="form-group">
                        {{Form::label('country', 'Country')}}
                        {{Form::text('country', $user->country, ['class' => 'form-control', 'placeholder' => 'Country'])}}
                    </div>
                </div>
            </div>
            <div class = "row">
                <div class="col-md-9">
                    <div class="form-group">
                        {{Form::label('city', 'City')}}
                        {{Form::text('city', $user->city, ['class' => 'form-control', 'placeholder' => 'City'])}}
                    </div>
                </div>
            </div>

            <div class = "row">
                <div class="col-md-9">
                    <div class="form-group">
                        {{Form::label('address', 'Address')}}
                        {{Form::text('address', $user->address, ['class' => 'form-control', 'placeholder' => 'Address'])}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {{Form::label('zip_code', 'Zip code')}}
                        {{ Form::number('zip_code',$user->zip_code,['class'=>'form-control','placeholder'=>'Zip code']) }}
                    </div>
                </div>
            </div>

            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Update', ['class'=>'btn btn-primary'])}}

        {!! Form::close() !!}
    </div>

@endsection
