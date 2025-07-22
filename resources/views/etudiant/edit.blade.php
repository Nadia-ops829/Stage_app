@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier l’Étudiant</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('etudiant.update', $etudiant) }}">
        @csrf
        @method('PUT')
        @include('etudiant.form', ['etudiant' => $etudiant])
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('etudiant.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
