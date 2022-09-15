<x-app-layout>
    <section class="dashboard" style="margin-top: 100px">
        <div class="container">
            <div class="row text-left">
                <div class=" col-lg-12 col-12 header-wrap mt-4">
                    <p class="story">
                        DASHBOARD
                    </p>
                    <h2 class="primary-header ">
                        My Bootcamps
                    </h2>
                </div>
            </div>
            @if (session()->has('findCheckout'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('findCheckout') }}
            </div>
            @endif
            <div class="row my-4">
                <table class="table">
                    <tbody>
                        @forelse ($checkouts as $checkout)
                        <tr class="align-middle">
                            <td width="18%">
                                <img src="/assets/images/item_bootcamp.png" height="120" alt="">
                            </td>
                            <td>
                                <p class="mb-2">
                                    <strong>{{ $checkout->camp->title }}</strong>
                                </p>
                                <p>
                                    {{ $checkout->created_at }}
                                </p>
                            </td>
                            <td>
                                <p class="mb-2">
                                    <strong>Expired</strong>
                                </p>
                                <p>{{ $checkout->expired }} Days</p>
                            </td>
                            <td>
                                <p class="mb-2">
                                    <strong>Price</strong>
                                </p>
                                <p>{{ $checkout->camp->price }}K</p>
                            </td>
                            <td>
                                <p class="mb-2">
                                    <strong>Status</strong>
                                </p>
                                {!! $checkout->is_paid ?
                                '<p><span class="text-green"><strong>Payment Success</strong></span></p>'
                                : '<p><span class="text-warning"><strong>Waiting for Payment</strong></span></p>' !!}
                            </td>
                            <td>
                                <a href="https://wa.me/085821559461?text=Hi, Saya ingin bertanya tentang kelas Gila Belajar"
                                    target="_blank" class="btn btn-primary">
                                    Contact Support
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <h3 class="text-center">Checkout Not Found</h3>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-app-layout>
