@extends('layouts.app')

@php
    $user = $user ?? session('user'); // fallback jika tidak dikirim compact
@endphp

@section('content')
<div style="background-color: #111; color: white; padding: 30px; max-width: 600px; margin: 50px auto; border-radius: 12px; box-shadow: 0 0 20px rgba(255,0,0,0.4);">

    <h2 style="color: #ff0000; margin-bottom: 25px;">Edit Profil</h2>

    @if(session('success'))
        <div style="background-color: #222; border: 1px solid #0f0; padding: 10px; margin-bottom: 20px; border-radius: 6px; color: #0f0;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background-color: #222; border: 1px solid #f00; padding: 10px; margin-bottom: 20px; border-radius: 6px; color: #f00;">
            <ul style="margin: 0; padding-left: 15px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Update --}}
    <form method="POST" action="{{ route('account.update') }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label for="username">Username</label><br>
            <input type="text" name="username" id="username"
                value="{{ old('username', $user['username']) }}"
                style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; color: white; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="first_name">First Name</label><br>
            <input type="text" name="first_name" id="first_name"
                value="{{ old('first_name', $user['first_name']) }}"
                style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; color: white; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="last_name">Last Name</label><br>
            <input type="text" name="last_name" id="last_name"
                value="{{ old('last_name', $user['last_name']) }}"
                style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; color: white; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 30px;">
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email"
                value="{{ old('email', $user['email']) }}"
                style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; color: white; border-radius: 6px;">
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <button type="submit"
                style="padding: 10px 20px; background-color: #ff0000; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                Simpan Perubahan
            </button>
    </form>

        {{-- Form Delete --}}
        <form method="POST" action="{{ route('account.destroy') }}">
            @csrf
            <button type="submit" onclick="return confirm('Yakin ingin menghapus akun?')"
                style="padding: 10px 20px; background-color: #222; color: #ff0000; border: 1px solid #ff0000; border-radius: 5px; cursor: pointer; font-weight: bold;">
                Hapus Akun
            </button>
        </form>
    </div>
</div>
@endsection
