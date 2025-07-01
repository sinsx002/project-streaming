@extends('layouts.app')

@php
    $user = $user ?? session('user'); // fallback jika tidak dikirim dari controller
@endphp

@section('content')
<div style="background-color: #111; color: white; padding: 30px; max-width: 600px; margin: 50px auto; border-radius: 12px; box-shadow: 0 0 20px rgba(255,0,0,0.4);">
    <h2 style="color: #ff0000; margin-bottom: 25px;">Profil Saya</h2>

    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 8px;">Username:</td>
            <td style="padding: 8px;">{{ $user['username'] }}</td>
        </tr>
        <tr>
            <td style="padding: 8px;">Nama Lengkap:</td>
            <td style="padding: 8px;">{{ $user['first_name'] }} {{ $user['last_name'] }}</td>
        </tr>
        <tr>
            <td style="padding: 8px;">Email:</td>
            <td style="padding: 8px;">{{ $user['email'] }}</td>
        </tr>
    </table>

    <div style="margin-top: 30px;">
        <a href="{{ route('account.edit') }}" style="padding: 10px 20px; background-color: #ff0000; color: white; border: none; border-radius: 5px; text-decoration: none; font-weight: bold;">
            Edit Profil
        </a>
    </div>
</div>
@endsection
