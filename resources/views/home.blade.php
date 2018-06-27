@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Agents <small>Invite list</small></h3>
                    <hr/>
                    <div><p>Add a <a href="/agent/invite">new agent</a>.</p></div>
                    <!--Table-->
                    <table class="table table-striped table-responsive-md btn-table">

                    <!--Table head-->
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Phone Number</th>
                            <th>Status</th>
                            <th>Link</th>
                        </tr>
                    </thead>
                    <!--Table head-->

                    <!--Table body-->
                    @if($invites->count() > 0)
                    <tbody>
                        @foreach($invites as $invite)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$invite->name}}</td>
                            <td>{{$invite->phone_number}}</td>
                            <td><p><span class="p-1 text-white {{ ($invite->status == 'pending') ? 'bg-warning' : 'bg-success'}}">{{$invite->status}}</span></p></td>
                            <td><a target="_blank" href="{{ url('/invite/agent/'.urlencode(strToLower($invite->name)).'?token='.urlencode($invite->token)) }}"><i class="fa fa-sign-in" aria-hidden="true"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endif
                    <!--Table body-->

                    </table>
                    <!--Table-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
