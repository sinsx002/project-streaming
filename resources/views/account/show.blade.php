@extends('layouts.app')

@php
    $user = session('user');
@endphp

@section('content')
<div style="background-color: #111; color: white; padding: 30px; max-width: 600px; margin: 50px auto; border-radius: 12px; box-shadow: 0 0 20px rgba(255,0,0,0.4);">
    <h2 style="color: #ff0000; margin-bottom: 25px;">Profil Saya</h2>

    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 10px;">Nama:</td>
            <td style="padding: 10px;">{{ $user['first_name'] ?? '' }} {{ $user['last_name'] ?? '' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px;">Email:</td>
            <td style="padding: 10px;">{{ $user['email'] ?? '' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px;">Username:</td>
            <td style="padding: 10px;">{{ $user['username'] ?? '' }}</td>
        </tr>
    </table>

    <div style="margin-top: 30px;">
        <a href="{{ route('account.edit') }}" class="btn btn-danger">Edit Profil</a>
        <a href="/dashboard/movies" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection
