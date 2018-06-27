@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ucfirst($statusType)}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert {{$alertClass}}" role="alert">
                            {{ session('status') }}
                        </div>
                    @else
                        <div class="alert alert-warning" role="alert">
                            Oops! no message found. How did you get here?
                        </div>
                    @endif

                    &nbsp;
                    &nbsp;
                    &nbsp;
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
