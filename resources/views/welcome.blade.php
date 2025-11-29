<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Welcome</title>

    <!-- Bootstrap CSS -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous"
    >
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-light shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-danger" href="#">Laravel</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="https://laravel.com/docs">Docs</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://laracasts.com">Laracasts</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://laravel-news.com">News</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://forge.laravel.com">Forge</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="py-5 mt-5 text-center">
        <div class="container">
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 318 90" width="120" height="120">
                    <path fill="#FF2D20" d="M105 27.5L90.8 18V37l14.2 9V27.5zM52.4 35.2l14.3-9V8.9L52.4 18v17.2zm52.5 9.1l-19.4-12.2v24.4l19.4-12.2zM35 18L19.8 8.9v17.3L35 35.2V18zM71.8 46.5L52.4 58.8v24.4l19.4-12.2V46.5zm14.2 9L66 67.7V92l20-12.2V55.5zM35 58.8L19.8 46.5v24.5L35 83.3V58.8zM52.4 46.5L35 58.8v24.5L52.4 71V46.5zM0 9.8v53.7L35 87.8V69.5L14.3 56.8V20.3L0 9.8zm86-1.7l14.2 9v17.3l14.2 9V10.5L86 0v8.1z"/>
                </svg>
            </div>

            <h1 class="fw-bold">Welcome to Laravel</h1>
            <p class="lead mb-4">Laravel is a web application framework with expressive, elegant syntax.</p>

            <div class="d-flex justify-content-center gap-3">
                <a href="https://laravel.com/docs" class="btn btn-outline-primary btn-lg">Documentation</a>
                <a href="https://forge.laravel.com" class="btn btn-primary btn-lg">Deploy Now</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-light text-center border-top">
        <div>
            <a href="https://laracasts.com" class="mx-2">Laracasts</a>
            <a href="https://laravel-news.com" class="mx-2">News</a>
            <a href="https://nova.laravel.com" class="mx-2">Nova</a>
            <a href="https://vapor.laravel.com" class="mx-2">Vapor</a>
            <a href="https://github.com/laravel/laravel" class="mx-2">GitHub</a>
        </div>
        <small class="text-muted">© 2025 Laravel Bootstrap Version</small>
    </footer>

    <!-- Bootstrap JS -->
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous">
    </script>

</body>
</html>
