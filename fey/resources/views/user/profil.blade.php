@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Profil Saya</h2>
    <div class="text-start">
        <a href="{{ route('user.create') }}" class="btn btn-primary mb-3">
            + Tambah Game
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>

    </div>
    
</div>
@endsection
