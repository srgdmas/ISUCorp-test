@extends('mail.layout')

@section('content')

    <h3>Hola, {{$data->name}}</h3>
    <p>
        Le escribimos desde ISU Corp. <br>
        Se realiz&oacute; una petici&oacute;n para restablecer su contrase&ntilde;a el <strong>{{$metadata["access_time"]}}</strong>,
        desde la direcci&oacute;n ip:<strong>{{$metadata["ip"]}}</strong>,
        utilizando el siguiente navegador web:<strong>{{$metadata["user_agent"]}}</strong><br>
        Si fue ud siga <a href="{{config('app.url')}}set-password/{{$data->token}}">ESTE ENLACE</a> para restablecer
        su contrase&ntilde;a. <strong style="color:red"> En caso contrario pongase en contacto con nosotros lo antes posible.</strong>
    </p>
@endsection()



