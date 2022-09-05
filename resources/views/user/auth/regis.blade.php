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
            <div class="input-password">
                <input type="password" class="form-control width @error('password') is-invalid @enderror" id="password"
                    name="password">
                <i class="bi bi-eye icon-eye"></i>
                <x-auth-validation-errors error='password' />
            </div>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-password">
                <input type="password" class="form-control width @error('password_confirmation') is-invalid @enderror"
                    id="password_confirmation" name="password_confirmation">
                <i class="bi bi-eye icon-eye-confirm"></i>
                <x-auth-validation-errors error='password_confirmation' />
            </div>
        </div>
        <div class="mb-3">
            <a href="{{ route('login') }}">You have account ?, Login Now!</a>
        </div>
        <button type="submit" class="btn btn-primary width">Register</button>
    </form>

    @push('costum-js')
    <script>
        const iconEye = document.querySelector('.icon-eye');
        const iconEyeConfirm = document.querySelector('.icon-eye-confirm');
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirmation');

        iconEye.addEventListener('click', function(event) {
            if(iconEye.classList.contains('bi-eye')) {
                iconEye.classList.remove('bi-eye');
                iconEye.classList.add('bi-eye-fill');
                password.type = 'text';
            } else {
                iconEye.classList.remove('bi-eye-fill');
                iconEye.classList.add('bi-eye');
                password.type = 'password';
            }
        });

        iconEyeConfirm.addEventListener('click', function(event) {
            if(iconEyeConfirm.classList.contains('bi-eye')) {
                iconEyeConfirm.classList.remove('bi-eye');
                iconEyeConfirm.classList.add('bi-eye-fill');
                passwordConfirm.type = 'text';
            } else {
                iconEyeConfirm.classList.remove('bi-eye-fill');
                iconEyeConfirm.classList.add('bi-eye');
                passwordConfirm.type = 'password';
            }
        });
    </script>
    @endpush
</x-guest-layout>
