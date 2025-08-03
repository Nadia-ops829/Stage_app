<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5dc;
            color: #1c1c1c;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            height: 100vh;
            background-color: #1c1c1c;
            color: #fff;
            position: fixed;
            width: 220px;
            top: 0;
            left: 0;
            padding-top: 2rem;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }

        .sidebar a:hover {
            background-color: #343a40;
        }

        .main-content {
            margin-left: 220px;
            padding: 2rem;
        }

        .logo {
            font-size: 1.4rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo">📋 Admin</div>
        <a href="{{ route('dashboard.admin') }}">🏠 Tableau de bord</a>
        <a href="{{ route('superadmin.admins.index') }}">👤 Gérer les admins</a>
        <a href="{{ route('superadmin.admins.etudiants') }}">🎓 Étudiants</a>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">🚪 Déconnexion</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

</body>
</html>
