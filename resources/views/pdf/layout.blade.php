<!doctype html >
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

        .footer .page-number:after {
            content: counter(page);
        }


    </style>
    @yield('style')
    <link rel="stylesheet" href="{{public_path('libs/bootstrap.min.css')}}">

    <title style="position: fixed"> Nuevos tiempos consultores | Reportes </title>

</head>
<body>
<div class="">
    <div class="row">
        <div class="col-xs-12">
            @yield('content')
        </div>
    </div>
</div>
</body>
<script src="{{public_path('libs/jquery.min.js')}}"></script>
<script src="{{public_path('libs/popper.min.js')}}"></script>
<script src="{{public_path('libs/bootstrap.min.js')}}"></script>
</html>
