<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Default Title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: #343a40;
            border-bottom: 2px solid #ccc;
        }
        .navbar-brand, .nav-link {
            color: white !important;
            font-size: 1.9rem;
        }
        .navbar {
            justify-content: center;
        }
        .sub-menu {
            background-color: #343a40;
            border-top: 1px solid white;
            border-bottom: 1px solid white;
        }
        .sub-menu a {
            color: white;
            margin: 0 35px;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <a class="navbar-brand" href="#">Home</a>
        </nav>
        <div class="sub-menu text-center">
            <a href="/">Home</a> |
            <a href="#">Login</a> |
            <a href="/create-post">Create Post</a>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Dashboard</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    <footer class="footer mt-auto py-3 bg-dark">
        <div class="container">
            <span class="text-muted">Place for footer content</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
