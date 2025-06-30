@extends('layouts.app')

@section('content')
<div class="container text-white mt-4">
    <h2>Edit Profil Akun</h2>

    <form method="POST" action="{{ route('account.update') }}">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('account.show') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
