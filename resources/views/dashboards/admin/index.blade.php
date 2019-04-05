@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Welcome {{ Auth::guard('admin')->user()->name }}

                    <!--<div class="links">
                        <a href="{//{ route('products.create') }}">Create Product</a>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
