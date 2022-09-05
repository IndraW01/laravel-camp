<x-app-layout>
    <section class="dashboard mt-5">
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
                                '<p><span class="text-green">Payment Success</span></p>'
                                : '<p>Waiting for Payment</p>' !!}
                            </td>
                            <td>
                                <a href="#" class="btn btn-primary">
                                    Get Invoice
                                </a>
                            </td>
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-app-layout>
