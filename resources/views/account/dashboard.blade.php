@extends('layouts.app') 

@section('content')
<div class="container text-white mt-4">
    <h2>Profil Akun</h2>
    <div class="bg-dark p-4 rounded">
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Tanggal Daftar:</strong> {{ $user->created_at->format('d M Y') }}</p>
    </div>
    <a href="{{ route('account.edit') }}" class="btn btn-warning mt-3">Edit Akun</a>
</div>
@endsection
