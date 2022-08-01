<x-guest-layout title="login" google="Sign In with Google">
    <form method="POST" action="{{ route('login.store') }}">
        @csrf
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
            <a href="{{ route('register') }}">Don't have account ?, Register Now!</a>
        </div>
        <button type="submit" class="btn btn-primary width">Login</button>
    </form>
</x-guest-layout>
