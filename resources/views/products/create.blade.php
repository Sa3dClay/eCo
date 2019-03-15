@if( Auth::user()->is_admin==1)
@extends('layouts.app')



@section('content')


    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Add Product</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        {!! Form::open(['action' => 'ProductsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        {{Form::label('name', 'Name')}}
                        {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{Form::label('price', 'Price')}}
                        {{ Form::number('price','',['class'=>'form-control','placeholder'=>'Price']) }}
                    </div>
                </div>
            </div>

            <div class = "row">
                <div class="col-md-9">
                    <div class="form-group">
                        {{Form::label('brand', 'Brand')}}
                        {{Form::text('brand', '', ['class' => 'form-control', 'placeholder' => 'Brand'])}}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{Form::label('quantity', 'Quantity')}}
                        {{ Form::number('quantity','',['class'=>'form-control','placeholder'=>'Quantity']) }}
                        <!--<input type="number" size="4" class="form-control qty text" title="quantity" value="1" min="0" step="1">-->
                    </div>
                </div>
            </div>

            <div class = "row">
                <div class="col-md-9">
                    <div class="form-group">
                        {{Form::label('category', 'Category')}}
                        {{Form::text('category', '', ['class' => 'form-control', 'placeholder' => 'Category'])}}
                    </div>
                </div>
                <div class="col-md-3">

                </div>
            </div>

            <div class = "row">
                <div class="col-md-9">
                    <div class="form-group">
                            {{Form::file('profile_pic' , ['class' => 'form-control'] )}}
                    </div>
                </div>
                <div class="col-md-3">
                </div>
            </div>

            <div class = "row">
                <div class="col-md-12">
                    <div class="form-group">
                            {{Form::label('desc', 'Body')}}
                            {{Form::textarea('desc', '', ['class' => 'form-control', 'placeholder' => 'Body Text'])}}
                    </div>
                </div>
            </div>
                
            
            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
            
        {!! Form::close() !!}
    </div>
    
@endsection
@endif
