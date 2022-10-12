<x-app-layout title="Berhasil Checkout">
    <section class="checkout mt-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12 col-12">
                    <img src="/assets/images/ill_register.png" height="400" class="mb-5" alt=" ">
                </div>
                <div class=" col-lg-12 col-12 header-wrap mt-4">
                    <p class="story">
                        WHAT A DAY!
                    </p>
                    <h2 class="primary-header ">
                        Berhasil Checkout Paket {{ $camp->title }}
                    </h2>
                    <p>
                        Silahkan menuju halaman Dashboard dan lakukan pembayaran
                    </p>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-primary mt-3">
                        My Dashboard
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
