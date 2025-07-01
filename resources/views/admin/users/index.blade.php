@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-danger mb-4">Daftar Pengguna</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $err)
                <div>{{ $err }}</div>
            @endforeach
        </div>
    @endif

    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $u)
                <tr>
                    <td>{{ $u['id_user'] }}</td>
                    <td>{{ $u['username'] }}</td>
                    <td>{{ $u['first_name'] ?? '' }} {{ $u['last_name'] ?? '' }}</td>
                    <td>{{ $u['email'] }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.destroy', $u['id_user']) }}" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
