@extends('mail.layout')

@section('content')

    <h3>Hola, {{$user->name}}</h3>
    <p>
        Se realiz&oacute; un inicio de sesi&oacute;n desde su cuenta a las <strong>{{$metadata["access_hours"]}}</strong>
        el <strong>{{$metadata["access_date"]}}</strong>, desde la direcci&oacute;n ip:<strong>{{$metadata["ip"]}}</strong>,
        utilizando el siguiente navegador web:<strong>{{$metadata["browser"]}}</strong><br>
        Le escribimos para asegurarnos que fue usted. Si fue usted puede ignorar este e-mail.<br>
        <strong style="color:red"> En caso contrario p&oacute;ngase en contacto con nosotros lo antes posible.</strong>
    </p>
@endsection()
