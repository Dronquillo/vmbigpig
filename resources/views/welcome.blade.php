<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Granja Porcina</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }
        .bg-cover {
            background: url('https://images.unsplash.com/photo-1589927986089-358123c9c5f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80') no-repeat center center;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .overlay {
            background-color: rgba(0,0,0,0.6);
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
        }
        .content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: #fff;
        }
        .btn-custom {
            margin: 10px;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 30px;
        }
    </style>
</head>
<body>
    <div class="bg-cover">
        <div class="overlay"></div>
        <div class="content">
            <h1 class="display-4 font-weight-bold">Bienvenido a la Granja Porcina</h1>
            <p class="lead mb-4">Sistema de gestión y control</p>
            <a href="{{ route('login') }}" class="btn btn-primary btn-custom">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </a>

        </div>
    </div>

    <!-- FontAwesome para íconos -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
