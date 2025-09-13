<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #1c1c1c;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
            padding-top: 1rem;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 2px 10px;
        }

        .sidebar a:hover {
            background-color: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }

        .sidebar a.active {
            background-color: rgba(255,255,255,0.2);
            border-left: 4px solid #fff;
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
            min-height: 100vh;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 2rem;
            padding: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .user-info {
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: auto;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }

        .role-badge {
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 12px;
            background: rgba(255,255,255,0.2);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar">
    <!-- Logo / Nom utilisateur -->
    <div class="logo fw-bold text-center">
        @if(Auth::user()->role === 'super_admin')
            👑 Super Admin
        @elseif(Auth::user()->role === 'admin')
            📋 Admin
        @elseif(Auth::user()->role === 'entreprise' && Auth::user()->entreprise)
            🏢 {{ Auth::user()->entreprise->nom }}
        @else
            🎓 {{ Auth::user()->nom }} {{ Auth::user()->prenom }}
        @endif
    </div>

    <!-- Navigation selon le rôle -->
    @if(Auth::user()->role === 'super_admin')
    <a href="{{ route('superadmin.dashboard') }}" class="{{ request()->routeIs('superadmin.dashboard*') ? 'active' : '' }}">
    <i class="fas fa-users-cog me-2"></i> Tableau de bord
</a>
        <a href="{{ route('superadmin.admins.index') }}" class="{{ request()->routeIs('superadmin.admins.*') ? 'active' : '' }}">
    <i class="fas fa-users-cog me-2"></i> Gestion des Admins
</a>

<a href="{{ route('admin.entreprises.create') }}" class="{{ request()->routeIs('admin.entreprises.*') ? 'active' : '' }}">
    <i class="fas fa-building me-2"></i> Gestion des Entreprises
</a>

<a href="{{ route('superadmin.admins.etudiants') }}" class="{{ request()->routeIs('superadmin.etudiants.*') ? 'active' : '' }}">
    <i class="fas fa-user-graduate me-2"></i> Gestion des Étudiants
</a>

<a href="{{ route('superadmin.stages.index') }}" class="{{ request()->routeIs('superadmin.stages.*') ? 'active' : '' }}">
    <i class="fas fa-handshake me-2"></i> Statistiques des Stages
</a>


       
        

    @elseif(Auth::user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt me-2"></i> Mon Tableau de bord
        </a>
        <a href="{{ route('admin.entreprises.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-building me-1"></i> Gérer les entreprises
        </a>
        <a href="{{ route('admin.etudiants.index') }}" class="btn btn-outline-info">
            <i class="fas fa-user-graduate me-1"></i> Gérer les étudiants
        </a>
        <a href="{{ route('stages.index') }}" class="{{ request()->routeIs('stages.index') ? 'active' : '' }}">
            <i class="fas fa-briefcase me-2"></i> Offres de stage
        </a>
        <a href="{{ route('candidatures.index') }}" class="{{ request()->routeIs('candidatures.index') ? 'active' : '' }}">
            <i class="fas fa-file-alt me-2"></i> Candidatures
        </a>
        <a href="{{ route('admin.statistiques') }}" class="{{ request()->routeIs('admin.statistiques') ? 'active' : '' }}">
            <i class="fas fa-chart-bar me-2"></i> Statistiques
        </a>

    @elseif(Auth::user()->role === 'entreprise')
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt me-2"></i> Mon Tableau de bord
        </a>
        <a href="{{ route('stages.index') }}" class="{{ request()->routeIs('stages.*') ? 'active' : '' }}">
            <i class="fas fa-briefcase me-2"></i> Mes Offres
        </a>
        <a href="{{ route('stages.create') }}" class="{{ request()->routeIs('stages.create') ? 'active' : '' }}">
            <i class="fas fa-plus me-2"></i> Publier une offre
        </a>
        <a href="{{ route('candidatures.recues') }}" class="{{ request()->routeIs('candidatures.recues') ? 'active' : '' }}">
            <i class="fas fa-users me-2"></i> Candidatures
        </a>

    @else
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt me-2"></i> Mon Tableau de bord
        </a>
        <a href="{{ route('stages.index') }}" class="{{ request()->routeIs('stages.*') ? 'active' : '' }}">
            <i class="fas fa-search me-2"></i> Rechercher des Stages
        </a>
        <a href="{{ route('candidatures.mes-candidatures') }}" class="{{ request()->routeIs('candidatures.mes-candidatures') ? 'active' : '' }}">
            <i class="fas fa-paper-plane me-2"></i> Mes Candidatures
        </a>
        <a href="{{ route('rapports.index') }}" class="{{ request()->routeIs('rapports.index') ? 'active' : '' }}">
            <i class="fas fa-user me-2"></i> Mes Rapports
        </a>
    @endif

    <!-- Section commune -->
    <div style="margin-top: 2rem;">
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="fas fa-user-cog me-2"></i> Paramètres
        </a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
        </a>
    </div>

    <!-- Informations utilisateur -->
    <div class="user-info">
        <div class="d-flex align-items-center">
            <div class="user-avatar">
                <span class="fw-bold">
                    {{ strtoupper(substr(Auth::user()->nom, 0, 1) . substr(Auth::user()->prenom, 0, 1)) }}
                </span>
            </div>
            <div>
                <div class="fw-bold">
                    @if(Auth::user()->role === 'entreprise' && Auth::user()->entreprise)
                        {{ Auth::user()->entreprise->nom }}
                    @else
                        {{ Auth::user()->nom }} {{ Auth::user()->prenom }}
                    @endif
                </div>
                <div class="small">{{ Auth::user()->email }}</div>
                <div class="role-badge">
                    @if(Auth::user()->role === 'super_admin')
                        👑 Super Admin
                    @elseif(Auth::user()->role === 'admin')
                        📋 Admin
                    @elseif(Auth::user()->role === 'entreprise')
                        🏢 Entreprise
                    @else
                        🎓 Étudiant
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>


    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
