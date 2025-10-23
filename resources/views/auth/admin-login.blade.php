<!-- resources/views/auth/admin-login.blade.php -->
@extends('layouts.auth')

@section('content')
<div class="login-container">
    <div class="login-header">
        <h1 class="h3 fw-bold">PressGO - Admin Login</h1>
        <p class="mb-0 opacity-75">Sistem Absensi Digital</p>
    </div>
    
    <div class="login-body">
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" 
                       class="form-control form-control-lg @error('username') is-invalid @enderror" 
                       id="username" 
                       name="username" 
                       value="{{ old('username') }}" 
                       placeholder="Masukkan username" 
                       required 
                       autofocus>
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" 
                       class="form-control form-control-lg @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       placeholder="Masukkan password" 
                       required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-login btn-lg">Login</button>
            </div>
        </form>

        {{-- <div class="text-center mt-4">
            <small class="text-muted">
                Login
            </small>
        </div> --}}
    </div>
</div>
@endsection