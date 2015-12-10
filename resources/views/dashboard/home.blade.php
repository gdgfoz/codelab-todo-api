@extends('dashboard.layout-template')

@section('content')

    <h3>dsfsdfsdf</h3>

    <h3>Dados</h3>



    @if( empty($token) )

        {!! Form::open(['method' => 'POST','class'=>'form-horizontal', 'url'=> route('dash.generateToken')]) !!}
        <div class="form-group">
            <dl class="dl-horizontal">
                <dt>Client Name</dt>
                <dd>{{$params['app_name']}}</dd>
            </dl>
        </div>

        {!! Form::hidden('username', $params['username']) !!}
        {!! Form::hidden('client_id', $params['client_id']) !!}
        {!! Form::hidden('grant_type', $params['grant_type']) !!}
        {!! Form::hidden('client_secret', $params['client_secret']) !!}
        {!! Form::hidden('scope', $params['scope']) !!}
        {!! Form::password('password', ['placeholde' => 'Sua Senha']) !!}
        {!! Form::submit('Generate token', ['name'=>'approve', 'class'=>'btn btn-success']) !!}

        {!! Form::close() !!}


    @else

        {!! Form::text('token', $token, ['class' => 'form-control']) !!}

        <p><a href="?reset=1">Reset Token</a></p>
    @endif



    <p><a href="#">Documentation routes API V1</a></p>

    <p><a href="/auth/logout">Logout</a></p>

@stop
