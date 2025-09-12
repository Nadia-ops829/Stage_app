@extends('layouts.admin')

@section('title', 'Créer une Entreprise')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header Card -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">
                    <i class="fas fa-building me-2"></i>
                    Créer une nouvelle entreprise
                </h4>
                <small>Ajoutez une nouvelle entreprise partenaire à votre plateforme</small>
            </div>
            <a href="{{ route('admin.entreprises.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus me-1"></i>
                Créer une entreprise
            </a>
        </div>
    </div>
</div>


            <!-- Form Card -->
            

            <!-- Info Card -->
            
        </div>
    </div>
</div>

<script>
// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
    const password = document.getElementById('password_confirmation');
    const icon = this.querySelector('i');
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});
</script>
@endsection
