@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Welcome {{ Auth::user()->name }}

                    @if ( Auth::user()->is_admin == '1' )
                        <p><a href="{{ route('products.create') }}">Create Product</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
