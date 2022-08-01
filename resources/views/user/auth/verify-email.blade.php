<x-guest-layout title="Verifikasi Email">

    <div class="mb-2">
        You haven't verified email, verify now!
    </div>

    @if (session('status') == 'verification-link-sent')
    <div class="alert alert-success" role="alert">
        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
    </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="mt-3">
        @csrf
        <button type="submit" class="border-0 p-3 btn btn-primary">Resend Verification Email</button>
    </form>
</x-guest-layout>
