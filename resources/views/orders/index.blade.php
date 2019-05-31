@extends('layouts.app')

@section('content')

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Order info.</h2>
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
                                @foreach ($products as $pro)
                                    <tr>
                                        <td>{{ $pro->name }}</td>
                                        <td class="text-center">{{ $pro->price . " $"  }}</td>
                                        <td class="text-center">{{ $pro->n_of_pro }}</td>
                                        <td class="text-right">{{ ($pro->price * $pro->n_of_pro) . " $" }}</td>
                                    </tr>
                                @endforeach
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
                                <tr>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line text-center"><strong>Order status</strong></td>
                                    <td class="thick-line text-right">{{ $status }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{route('make_pdf',[$invoice_id,$user_id,$totalCost])}}" style="float:right;">
              @csrf
              <button type="submit" class="btn btn-danger btn-md" ><i class="glyphicon glyphicon-floppy-disk"></i> Generate PDF invoice</span></button>
            </form>
        </div>
    </div>
</div>


@endsection
