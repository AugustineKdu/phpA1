<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

        header {
            background-color: #0D0D0D;
            color: #F2BF5E;
            text-align: center;
        }

        .footer {
            background-color: #0D0D0D;
            color: #D9D0C7;
            text-align: center;
        }

        body {
            background-color: #343a40;
            color: #D9D0C7;
            text-align: center;
        }


        a, a:hover, a:active, a:visited {
            color: #F2BF5E;
        }

        .navbar-brand {
            color: #D9D0C7 !important;
            margin: 0 auto;
        }


        .navbar-brand, .nav-link, .sub-menu a {
            font-size: 1.9rem;
        }

        .sub-menu {
            background-color: #343a40;
            border-top: 5px solid #F2BF5E;
            border-bottom: 5px solid #F2BF5E;
        }

        .sub-menu a {
            margin: 0 35px;
            font-size: 1.5rem;
            color: #D9D0C7;
        }


        .container-fluid {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }


        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg justify-content-center" style="background-color: #262626;">
            <a class="navbar-brand" href="#">@yield('navbar-title', 'Home')</a>
        </nav>
        <div class="sub-menu text-center">
            <a href="/">Home</a> |
            <a href="/search">Search</a> |
            <a href="/create-user">Create User</a>
        </div>
    </header>

    <div class="container-fluid" style="padding-bottom: 60px;">
        <div class="row justify-content-center">
            <main role="main" class="col-lg-20">
                @yield('content')
            </main>
        </div>
    </div>

    <footer class="footer mt-auto py-3">
        <div class="container d-flex justify-content-between">
            <span>@Created by Augustine Kim (s5125270)</span>
            <a href="/admin">Admin Portal</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
