@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Agents <small>List</small></h3>
                    <div><p>Add a <a href="/agent/new">new agent</a>.</p></div>
                    <hr/>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
