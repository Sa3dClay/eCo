<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
}
th {
  text-align: left;
}
</style>

<div class="header-area">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
               <div class="user-menu">
                    <div class="logo">
                       <img src="{{ asset('img/eCo.png') }}" style="height: 100px;width: 100px;display: inline"/>
                         <h3 style="display: inline;margin-left: 200px">Invoice of an order</h3>
                    </div>
                </div>
                <div class="col-md-12">
                  <p>Name:<b> {{$user->name}}</b></p>
                  </br>
                  <p>Address:<b> {{$user->country}},{{$user->city}},{{$user->address}}</b></p> <!-- country,city,address-->
                  </br>
                  <p>Email:<b> {{$user->email}}</b></p>
                  </br>
                  <p>Phone number:<b> {{$user->phone_number}}</b></p>
                  </br>
                  <p>Zip code:<b> {{$user->zip_code}}</b></p>
                  </br>
                  <p>Payment method:<b> {{$user->payment_m}}</b></p>
                  <br/>
                </div>
                <div class="col-sm-6">
                  <table>
                    <thead>
                      <tr>
                        <th style="color: #1ABC9C">product name</th>
                        <th style="color: #1ABC9C">category</th>
                        <th style="color: #1ABC9C">number of ordered items</th>
                        <th style="color: #1ABC9C">product price</th>
                        <th style="color: #1ABC9C">cost</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                              <td>{{$product->name}}</td>
                              <td>{{$product->category}}</td>
                              <td>{{$product->n_of_pro}}</td>
                              <td>{{$product->price}}</td>
                              <td>{{$product->price * $product->n_of_pro}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                  <p>Total cost+(5% for shipping&service):<b> {{$total}}</b></p>
                </div>
            </div>
        </div>
    </div>
</div>
