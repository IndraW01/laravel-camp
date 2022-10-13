<x-app-layout>
    <section class="dashboard" style="margin-top: 100px">
        <div class="container">
            <div class="row text-left">
                <div class=" col-lg-12 col-12 header-wrap mt-4">
                    <p class="story">
                        DASHBOARD
                    </p>
                    <h2 class="primary-header ">
                        User Camp Checkouts
                    </h2>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            Camp Checkouts
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">User</th>
                                        <th scope="col">Camp</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Register Date</th>
                                        <th scope="col">Paid Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($checkouts as $checkout)
                                    <tr>
                                        <th scope="row">{{ $checkout->user->name }}</th>
                                        <td>{{ $checkout->camp->title }}</td>
                                        <td>

                                            Rp. {{ $checkout->total < 1000 ? number_format($checkout->total * 1000)
                                                :number_format($checkout->total) }}
                                                @if ($checkout->discount)
                                                <span class="ms-2 badge bg-success">Disc {{
                                                    $checkout->discount_percentage
                                                    }}%</span>
                                                @endif
                                        </td>
                                        <td>{{ $checkout->created_at }}</td>
                                        <td>
                                            {!! $checkout->payment_status == 'PAID' ?
                                            '<span class="badge bg-success">'. $checkout->payment_status .'</span>' :
                                            '<span class="badge bg-warning">'. $checkout->payment_status .'</span>' !!}
                                        </td>
                                    </tr>
                                    @empty
                                    <h3 class="text-center">Checkout Not Found</h3>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
