@extends('mail.layout')

@section('content')
    <h3>Hola, {{$user->name}}.
    </h3>
    <br>
    <p>
        Su cuenta ha sido creada exitosamente en <strong>ISU Corp</strong>.
        Le agradecemos desde ya por utilizar nuestros servicios.
    </p>
    <h3>

        <br> Para confirmar su email y establecer una contraseña a su perfil, siga
        <a href="{{config('app.url')}}set-password/{{$user->token}}">ESTE ENLACE</a>
    </h3>

@endsection
