@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un Étudiant</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('etudiant.store') }}">
        @csrf
        @include('etudiant.form')
        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('etudiant.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
