@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<style>
    body {
        overflow: hidden;
    }
</style>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card w-50 p-5">
            <div class="my-2">
                <h2 class="text-center">Register</h2>
            </div>
            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama: </label>
                    <input type="text" id="nama" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email: </label>
                    <input type="text" id="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password: </label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirm" class="form-label">Konfirmasi Password: </label>
                    <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
                </div>

                <div class="d-flex justify-content-around">
                    <button type="submit" class="btn btn-primary">Register</button>
                    <a href="{{ route('loginForm') }}" class="btn btn-light">Login</a>
                </div>
            </form>
        </div>
    </div>

@endsection