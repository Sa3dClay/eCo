@extends('layouts.app')

@section('content')

<div class="container">
    <form method="POST" action="{{url('contact')}}">
        @csrf
        {{-- <div class="form-group">
          <label for="exampleFormControlInput1">Email address</label>
          <input type="email" class="form-control" name="email" id="exampleFormControlInput1" placeholder="name@example.com">
        </div> --}}
        <div class="form-group">
          <label for="exampleFormControlTextarea1">Message</label>
          <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">
                Send
        </button>
      </form>
</div>
    
@endsection