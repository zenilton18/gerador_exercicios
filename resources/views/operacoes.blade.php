<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{env('APP_NAME')}}</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png')}}" type="image/png">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/bootstrap/bootstrap.min.css')}}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css')}}">
</head>

<body>

    <!-- logo -->
    <div class="text-center my-3">
        <img src="assets/images/logo.jpg" alt="logo" class="img-fluid">
    </div>
 <!-- operations -->
    <div class="container">

        <hr>

        <div class="row">

            @foreach ($exercicios as $exercio)

                <div class="col-3 display-6 mb-3">
                    <span class="badge bg-dark">{{ str_pad($exercio['numero_exercicio'],2,'0', STR_PAD_LEFT)}}</span>
                    <span>{{$exercio['numero_exercicio']}}</span>
                    <span>+</span>
                    <span>{{$exercio['numero_exercicio']}}</span>
                </div>
   
            @endforeach
        </div>

        <hr>

    </div>

    <!-- print version -->
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <a href="{{ route('principal')}}" class="btn btn-primary px-5">VOLTAR</a>
            </div>
            <div class="col text-end">
                <a href="{{ route('exportar')}}" class="btn btn-secondary px-5">DESCARREGAR EXERCÍCIOS</a>
                <a href="{{ route('listar')}}" class="btn btn-secondary px-5">IMPRIMIR EXERCÍCIOS</a>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer class="text-center mt-5">
        <p class="text-secondary">MathX &copy; <span class="text-info">[ANO]</span></p>
    </footer>

    <!-- bootstrap -->
    <script src="{{asset('assets/bootstrap/bootstrap.bundle.min.js')}}"></script>
</body>

</html>