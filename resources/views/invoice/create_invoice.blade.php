@extends('layouts.app')

@section('content')

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Check Out</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        <br>

        <h2>Order</h2>

        <br>

        <div class="row">
            <div class="col-md-12">
                <br>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Order summary</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td><strong>Item</strong></td>
                                        <td class="text-center"><strong>Price</strong></td>
                                        <td class="text-center"><strong>Quantity</strong></td>
                                        <td class="text-right"><strong>Totals</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- LOOP -->
                                    <?php $i=0 ?>
                                    @foreach ($products as $pro)
                                        <tr>
                                            <td>{{ $pro->name }}</td>
                                            <td class="text-center">{{ $pro->price . " $"  }}</td>
                                            <td class="text-center">{{ $pro->n_of_pro }}</td>
                                            <td class="text-right">{{ $totalCost_per_product[$i] . " $" }}</td>
                                        </tr>
                                        <?php $i++ ?>
                                    @endforeach

                                    <tr>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                        <td class="thick-line text-right">{{ $subTotalCost . " $"  }}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center"><strong>Shipping AND Service</strong></td>
                                        <td class="no-line text-right">{{ $eCoPercintage }}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center"><strong>Total</strong></td>
                                        <td class="no-line text-right">{{ $totalCost . " $"  }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <h2>Personal Info</h2>

        <br>

        {!! Form::open(['action' => 'InvoiceController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'onSubmit' => 'ifclicked()']) !!}

            <div class = "row">
                <div class="col-md-12">
                    <div class="form-group">
                        <h5>Name</h5>
                        @auth
                            <p>{{ Auth::user()->name }}</p>
                        @else
                            <p>Guest</p>
                        @endauth
                    </div>
                </div>
            </div>

            <div class = "row">
                <div class="col-md-12">
                    <div class="form-group">
                        <h5>Email</h5>
                        @auth
                            <p>{{ Auth::user()->email }}</p>
                        @else
                            <p>Guest</p>
                        @endauth
                    </div>
                </div>
            </div>
            <input type="checkbox" id="use_info" name="use_info" value="1" onclick="change()"><b> Use my recent data</b></br></br>
            <div class="container" id="info">
              <div class = "row">
                  <div class="col-md-12">
                      <div class="form-group">
                          {{Form::label('address', 'Address')}}
                          {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Address'])}}
                      </div>
                  </div>
              </div>

              <div class = "row">
                  <div class="col-md-12">
                      <div class="form-group">
                          {{Form::label('country', 'Country')}}
                          {{Form::text('country', '', ['class' => 'form-control', 'placeholder' => 'Country'])}}
                      </div>
                  </div>
              </div>

              <div class = "row">
                  <div class="col-md-12">
                      <div class="form-group">
                          {{Form::label('city', 'City')}}
                          {{Form::text('city', '', ['class' => 'form-control', 'placeholder' => 'City'])}}
                      </div>
                  </div>
              </div>

              <div class = "row">
                  <div class="col-md-12">
                      <div class="form-group">
                          {{Form::label('phone_number', 'Phone Number')}}
                          {{Form::number('phone_number', '', ['class' => 'form-control', 'placeholder' => 'Phone Number', 'maxlength'=>20 , 'oninput' => "maxLengthCheck(this)"])}}
                      </div>
                  </div>
              </div>

              <div class = "row">
                  <div class="col-md-12">
                      <div class="form-group">
                          {{Form::label('zip_code', 'Zip Code')}}
                          {{Form::number('zip_code', '', ['class' => 'form-control', 'placeholder' => 'Zip Code' ,'maxlength'=>10 ,  'oninput' => "maxLengthCheck(this)"])}}
                      </div>
                  </div>
              </div>

              <hr>

              <h2>Payment Method</h2>

              <br>

              <div class = "row">
                  <div class="col-md-3">
                      <div class="form-group">
                          <input type="radio" name="payment_m" value="Bank Account"> {{Form::label('BankAccount', 'Bank Account')}}
                      </div>
                  </div>
                  <div class="col-md-9">
                      <div class="form-group">
                          {{Form::label('bankNumber', 'Bank Account number')}}
                          {{ Form::number('bankNumber','',['class'=>'form-control','placeholder'=>'Bank Account number']) }}
                      </div>
                  </div>
              </div>

              <div class = "row">
                  <div class="col-md-3">
                      <div class="form-group">
                          <input type="radio" name="payment_m" value="Visa"> {{Form::label('visa', 'Visa')}}
                      </div>
                  </div>
                  <div class="col-md-9">
                      <div class="form-group">
                          {{Form::label('visaNumber', 'Visa number')}}
                          {{ Form::number('visaNumber','',['class'=>'form-control','placeholder'=>'Visa number']) }}
                      </div>
                  </div>
              </div>

              <div class = "row">
                  <div class="col-md-3">
                      <div class="form-group">
                          <input type="radio" name="payment_m" value="PayPal"> {{Form::label('visa', 'PayPal')}}
                      </div>
                  </div>
                  <div class="col-md-9">
                      <div class="form-group">
                          {{Form::label('paypalAccount', 'PayPal')}}
                          {{ Form::email('paypalAccount','',['class'=>'form-control','placeholder'=>'PayPal Account']) }}
                      </div>
                  </div>
              </div>
          </div>
            {{Form::submit('Order', ['class'=>'btn btn-primary','id'=>'submit'])}}

        {!! Form::close() !!}

        <br>

    </div>


    <script>

        function maxLengthCheck(object)
        {
            if (object.value.length > object.maxLength)
            object.value = object.value.slice(0, object.maxLength)
        }
        function change() {
          var checkBox = document.getElementById("use_info");
          var info = document.getElementById("info");
          if (checkBox.checked == true){
            info.style.display = "none";
          } else {
            info.style.display = "block";
          }
        }
        function ifclicked() {
          document.getElementById("submit").disabled = true;
        }

    </script>

@endsection
