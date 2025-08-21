<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Mi Plataformaa</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
        body {
            background-color: #f8f9fa;
        }
        .main-container {
            margin-top: 30px;
        }
        .section-card {
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .section-header {
            background-color: #0d6efd;
            color: white;
            padding: 15px;
            font-size: 1.4rem;
            font-weight: bold;
        }
        .section-body {
            padding: 20px;
            background-color: white;
        }
    </style>
</head>
<body>

    <div class="container main-container">
        <div class="section-card">
            <div class="section-header">
                @yield('title')
            </div>

            <div class="section-body">
                @yield('content')
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Bootstrap JS (opcional si usas modales, dropdowns, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
