<x-guest-layout title="Register" google="Sign Up with Google">
    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control width @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name') }}">
            <x-auth-validation-errors error='name' />
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control width @error('email') is-invalid @enderror" id="email" name="email"
                value="{{ old('email') }}">
            <x-auth-validation-errors error='email' />
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control width @error('password') is-invalid @enderror" id="password"
                name="password">
            <x-auth-validation-errors error='password' />
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control width @error('password_confirmation') is-invalid @enderror"
                id="password_confirmation" name="password_confirmation">
            <x-auth-validation-errors error='password_confirmation' />
        </div>
        <div class="mb-3">
            <a href="{{ route('login') }}">You have account ?, Login Now!</a>
        </div>
        <button type="submit" class="btn btn-primary width">Register</button>
    </form>
</x-guest-layout>
